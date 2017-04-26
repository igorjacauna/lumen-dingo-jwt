FORMAT: 1A

# Example

# Users
User resource representation.

## list of users [GET /users]
Retrieve all users

+ Request (application/json)

+ Response 200 (application/json)
    + Body

            {
                "message": "ok",
                "data": "ARRAY USERS"
            }

## Get user [GET /user/{id}]
Retrieve specific user data, passing id on URL

+ Request (application/json)

+ Response 200 (application/json)
    + Body

            {
                "message": "ok",
                "data": {
                    "id": 10,
                    "name": "..."
                }
            }

## Register user [POST /user/register]
Register a new user with a 'name', `email` and `password`.

+ Request (application/json)
    + Body

            {
                "name": "Foo Bar",
                "email": "foo@bar.com",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "email": "foo@bar.com"
            }

## Signin a user [POST /login]
User log in

+ Request (application/json)
    + Body

            {
                "email": "foo@bar.com",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "message": "token_generated",
                "data": {
                    "token": "TOKEN"
                }
            }

## Invalidate user [DELETE /user/invalidate]
Invalidate a token

+ Request (application/json)

+ Response 200 (application/json)
    + Body

            {
                "message": "token_invalidated"
            }

## Refresh token [PATCH /user/refresh]
Refresh user token

+ Request (application/json)

+ Response 200 (application/json)
    + Body

            {
                "message": "token_refreshed",
                "data": {
                    "token": "TOKEN"
                }
            }

## Get user [GET /user/me]
Get user data from token on Authorization header

+ Request (application/json)

+ Response 200 (application/json)
    + Body

            {
                "message": "token_refreshed",
                "data": {
                    "id": 10,
                    "name": "..."
                }
            }