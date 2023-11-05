# Per diem amount calculator

Simple REST API for calculation the per diem amount due
for a business trip for an employee. 

### run project

* install docker and docker-compose
* clone project
* go to project root dir <br>
```cd per-diem-calc```
* run containers <br>
```docker-compose up server```
* migrate and seed database <br>
```docker-compose run artisan migrate``` <br>
```docker-compose run artisan db:seed```

### run tests
```docker-compose run artisan test```

### API

![()](https://img.shields.io/static/v1?label=&message=POST&color=30c030) **<font color='30c030'>Add employee to database</font>** <br> ```/add/employee```
#### response
```json
{
    "employee_id": 99
}
```
---
![()](https://img.shields.io/static/v1?label=&message=POST&color=30c030) **<font color='30c030'>Add delegation to database</font>** <br> ```/add/delegation```
#### request
```json
{
    "start_date": "2023-11-06 08:00:00",
    "end_date": "2023-11-10 16:00:00",
    "country": "PL",
    "employee_id": 7
}
```
#### response
```json
{
    "employee_id": 99
}
```
---
![()](https://img.shields.io/static/v1?label=&message=GET&color=0c90ff) **<font color='0c90ff'>Get per diem amounts for employee</font>** <br> ```/get/perdiem```
#### request with param
```
employee_id: 7
```
#### response
```json
[
    {
        "start": "2023-11-06 08:00:00",
        "end": "2023-11-10 16:00:00",
        "country": "PL",
        "amount_due": 50,
        "currency": "PLN"
    },
    {
        "start": "2023-11-13 08:00:00",
        "end": "2023-11-15 16:00:00",
        "country": "DE",
        "amount_due": 150,
        "currency": "PLN"
    }
]
```