# Prueba Kinedu

Creación de dos end points con paginación

1. Obtener todos los hijos del nodo enviado como parámetro en la url.

Ejemplo

```http

 
@url = http://localhost:8000/api/v1/nodes/1/children?page=0
GET {{url}} HTTP/1.1
Accept: application/json
Content-Type: application/json



 ```

Response

```http
HTTP/1.1 200 OK
Host: localhost:8000
Date: Sun, 11 Apr 2021 21:26:47 GMT, Sun, 11 Apr 2021 21:26:47 GMT
Connection: close
X-Powered-By: PHP/7.2.32
Cache-Control: no-cache, private
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

[
  {
    "id": 1,
    "name": "np",
    "parent_id": null,
    "created_at": "2021-04-10T00:16:48.000000Z",
    "updated_at": "2021-04-10T00:16:48.000000Z",
    "deleted_at": null
  },
  {
    "id": 3,
    "name": "sh1",
    "parent_id": 1,
    "created_at": "2021-04-10T00:18:23.000000Z",
    "updated_at": "2021-04-10T00:18:23.000000Z",
    "deleted_at": null
  },
  {
    "id": 4,
    "name": "c1",
    "parent_id": 3,
    "created_at": "2021-04-10T00:18:23.000000Z",
    "updated_at": "2021-04-10T00:18:23.000000Z",
    "deleted_at": null
  }
]
```



2. Obtener todos los nodos padres del nodo enviado como parámetro en la url.

Ejemplo 
```http

@url = http://localhost:8000/api/v1/nodes/12/parents?page=0
GET {{url}} HTTP/1.1
Accept: application/json
Content-Type: application/json

```


Response 

```http
HTTP/1.1 200 OK
Host: localhost:8000
Date: Sun, 11 Apr 2021 21:28:18 GMT, Sun, 11 Apr 2021 21:28:18 GMT
Connection: close
X-Powered-By: PHP/7.2.32
Cache-Control: no-cache, private
Content-Type: application/json
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 58
Access-Control-Allow-Origin: *

[
  {
    "id": 12,
    "name": "hhhf2",
    "parent_id": 11,
    "created_at": 2021-04-10T00:18:23.000000Z,
    "updated_at": 2021-04-10T00:18:23.000000Z,
    "deleted_at": null
  },
  {
    "id": 11,
    "name": "hhf2",
    "parent_id": 10,
    "created_at": 2021-04-10T00:18:23.000000Z,
    "updated_at": 2021-04-10T00:18:23.000000Z,
    "deleted_at": null
  },
  {
    "id": 10,
    "name": "hf2",
    "parent_id": 8,
    "created_at": 2021-04-10T00:18:23.000000Z,
    "updated_at": 2021-04-10T00:18:23.000000Z,
    "deleted_at": null
  }
]

```
