# Banking API with PHP Laravel

This is a banking api byilt with php laravel

Endpoints

### SIGNUP

 > Endpoint: `/api/signup`

 > HTTP METHOD: `POST`

 > Sample: 

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"name":"abc","email":"abc@abc.com","password":"password", "password_confirmation":"password"}' \
 <https://api.example.com/api/signup>
```
> Sample Return:
```json
{
    "status": "success",
    "message": "Thanks for using our service",
    "data": {
        "user": {
            "id": 1,
            "name": "abc",
            "email": "abc@abc.com",
            "email_verified_at": null,
            "created_at": "2022-10-14T20:15:59.000000Z",
            "updated_at": "2022-10-14T20:15:59.000000Z"
        },
        "token": "11|z2Ez0QbdtcqI4xBvF6q5OEj63Nr7DSKWiM2hU2sV"
    }
}
```

### LOGIN

 > Endpoint: `/api/login`

 > HTTP METHOD: `POST`

 > Sample:

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"email":"abc@abc.com","password":"password"}' \
 <https://api.example.com/api/login>
```

> Sample Return:

```json
{
    "status": "success",
    "message": "Thanks for using our service",
    "data": {
        "user": {
            "id": 1,
            "name": "abc",
            "email": "abc@abc.com",
            "email_verified_at": null,
            "created_at": "2022-10-14T20:15:59.000000Z",
            "updated_at": "2022-10-14T20:15:59.000000Z"
        },
        "token": "11|z2Ez0QbdtcqI4xBvF6q5OEj63Nr7DSKWiM2hU2sV"
    }
}
```

### CREATING A BANK ACCOUNT

 > Endpoint: `/api/account`

 > HTTP METHOD: `POST`

 > Sample:

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"name":"abc`s Acount","account_type":"savings","password":"password",
 "password_confirmation":"password"}' \
 <https://api.example.com/api/account>
```

> Sample Return:

```json
{
    "status": "success",
    "message": "Thanks for using our service",
    "data": {
        "message": "Account created successfully",
        "data": {
            "name": "Ridox James",
            "password": null,
            "account_type": "savings",
            "account_number": "2076630911",
            "account_balance": 10000,
            "account_status": "active",
            "user_id": 26,
            "updated_at": "2022-10-14T22:39:49.000000Z",
            "created_at": "2022-10-14T22:39:49.000000Z",
            "id": 35
        }
    }
}
```


### TRANSFERING FROM ONE BANK TO ANOTHER

 > Endpoint: `/api/account/tranfer`

 > HTTP METHOD: `POST`

 > Sample:

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"from":"231405632",
 "to":"458964752",
 "anount":1000,"password":"password"}' \
 <https://api.example.com/api/account/tranfer>
```

> Sample Return:

```json
{
    "status": "success",
    "message": "Transfer successful",
    "data": {
        "old_balance": 9000,
        "new_balance": 8000,
        "recipient": "Chibueze Aniezeofor",
        "recipient_account": "5629610676"
    }
}
```
### GETTING ACCOUNT BALANCE

 > Endpoint: `/api/account/balance`

 > HTTP METHOD: `POST`

 > Sample:

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"account_number":"231405632","password":"password"}' \
 <https://api.example.com/api/account/balance>
```

> Sample Return:

```json
{
    "status": "success",
    "message": "Thanks for using our service",
    "data": {
        "message": "Balance retrieved successfully",
        "data": 9100
    }
}
```


### GETTING AN ACCOUNT TRANSACTION HISTORY

 > Endpoint: `/api/account/transactions`

 > HTTP METHOD: `POST`

 > Sample:

```curl
 curl -X POST -H "Content-Type: application/json" \
 -d '{"account_number":"231405632","password":"password"}' \
 <https://api.example.com/api/account/transactions>
```

> Sample Return:

```json
{
    "status": "success",
    "message": "Thanks for using our service",
    "data": [
        {
            "id": 4,
            "account_id": 27,
            "transaction_type": "Credit",
            "transaction_reference": "TRX_63475e268377e",
            "account_number": "5629610676",
            "amount": "1000",
            "narration": "transfer from 5681956517",
            "old_balance": 4000,
            "new_balance": 5000,
            "status": "success",
            "created_at": "2022-10-13T00:39:02.000000Z",
            "updated_at": "2022-10-13T00:39:02.000000Z"
        },
        {
            "id": 6,
            "account_id": 27,
            "transaction_type": "Credit",
            "transaction_reference": "TRX_63475e73764a8",
            "account_number": "5629610676",
            "amount": "1000",
            "narration": "transfer from 5681956517 (Chibueze Aniezeofor)",
            "old_balance": 5000,
            "new_balance": 6000,
            "status": "success",
            "created_at": "2022-10-13T00:40:19.000000Z",
            "updated_at": "2022-10-13T00:40:19.000000Z"
        },
        {
            "id": 8,
            "account_id": 27,
            "transaction_type": "Debit",
            "transaction_reference": "TRX_63475ee1d0781",
            "account_number": "5629610676",
            "amount": "1000",
            "narration": "transfer to 5681956517 (Mike James)",
            "old_balance": 6000,
            "new_balance": 5000,
            "status": "success",
            "created_at": "2022-10-13T00:42:09.000000Z",
            "updated_at": "2022-10-13T00:42:09.000000Z"
        }
    ]
}
```

THIS IS BUILT WITH 💗 BY [Aniezeofor Chibueze](https://github.com/codad5)"# PHP-LARAVEL-BANKING-API" 
