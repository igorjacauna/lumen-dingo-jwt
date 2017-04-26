<?php

namespace App\Http\Controllers\Auth;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\User;

/**
 * User resource representation.
 *
 * @Resource("Users")
 */
class UserController extends Controller
{
    protected $item_per_page = 20;

    /**
     * list of users
     *
     * Retrieve all users
     *
     * @Get("/users")
     * @Request()
     * @Response(200, body={
     *     "data": "ARRAY USERS",
     *     "meta": {
                "pagination": {
                    "total": 1,
                    "count": 1,
                    "per_page": 20,
                    "current_page": 1,
                    "total_pages": 1,
                    "links": {
                        "next": "NEXT_PAGE",
     *                  "prev": "PREV_PAGE"
                    }
                }
            }
     * })
     */
    public function users()
    {
        $users = User::paginate($this->item_per_page);
        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * Get user
     *
     * Retrieve specific user data, passing id on URL
     *
     * @Get("/user/{id}")
     * @Request()
     * @Response(200, body={
     *     "message": "ok",
     *     "data": {
     *          "id" : 10,
     *          "name" : "..."
     *     }
     * })
     */
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return $this->response->item($user, new UserTransformer);
    }

    /**
     * Register user
     *
     * Register a new user with a 'name', `email` and `password`.
     *
     * @Post("/user/register")
     * @Request({
     *     "name": "Foo Bar",
     *     "email": "foo@bar.com",
     *     "password": "bar"
     * })
     * @Response(200, body={"id": 10, "email": "foo@bar.com"})
     */
    public function register(Request $request)
    {
        try {
            $this->validateRegister($request);
        } catch (HttpResponseException $e) {
            $this->badRequest(trans('auth.failed_register'));
        }

        $user = null;

        try {
            $user = User::create($request->json()->all());
        } catch (Exception $e) {
            $this->exception(trans('auth.failed_create'), ERROR_ON_CREATE_USER, $e);
        }

        return $user;
    }

    /**
     * Signin a user
     *
     * User log in
     *
     * @Post("/login")
     * @Request({
     *     "email": "foo@bar.com",
     *     "password": "bar"
     * })
     * @Response(200, body={
     *     "message": "token_generated",
     *     "data": {
     *          "token": "TOKEN"
     *     }
     * })
     */
    public function login(Request $request)
    {
        try {
            $this->validateLogin($request);
        } catch (HttpResponseException $e) {
            $this->badRequest(trans('auth.failed_invalid'));
        }

        try {
            // Attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($this->getCredentials($request))) {
                $this->accessDenied(trans('auth.failed'));
            }
        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            $this->exception(trans('auth.failed_generate_token'), WRONG_PASSWORD_OR_LOGIN, $e);
        }

        // All good so return the token
        return $this->onAuthorized($token);
    }

    /**
     * Invalidate user
     *
     * Invalidate a token
     *
     * @Delete("/user/invalidate")
     * @Request()
     * @Response(200, body={
     *     "message": "token_invalidated",
     * })
     */
    public function deleteInvalidate()
    {
        $token = JWTAuth::parseToken();

        $token->invalidate();

        return ['message' => trans('auth.token_invalidated')];
    }

    /**
     * Refresh token
     *
     * Refresh user token
     *
     * @Patch("/user/refresh")
     * @Request()
     * @Response(200, body={
     *     "data": {
     *          "token": "TOKEN"
     *     }
     * })
     */
    public function refresh()
    {
        $token = JWTAuth::parseToken();

        $newToken = $token->refresh();

        return [
            'data' => [
                'token' => $newToken
            ]
        ];
    }

    /**
     * Get user
     *
     * Get user data from token on Authorization header
     *
     * @Get("/me")
     * @Request()
     * @Response(200, body={
     *     "data": {
     *          "id" : 10,
     *          "name" : "..."
     *     }
     * })
     */
    public function authenticatedUser()
    {
        return [
            'data' => get_user()
        ];
    }

    /**
     * Validate authentication request.
     *
     * @param  Request $request
     * @return void
     * @throws HttpResponseException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
    }

    protected function validateRegister(Request $request)
    {
        Validator::make($request->json()->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255|min:6',
        ])->validate();
    }

    /**
     * What response should be returned on authorized.
     *
     * @return array
     */
    protected function onAuthorized($token)
    {
        return [
            'data' => [
                'token' => $token,
            ]
        ];
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }
}
