import os
from pymysql.cursors import DictCursor
from requests import Session

app_url = "http://localhost:8000"

session = Session()

database = {
    "host"          : os.getenv("DATABASE_URI"),
    "user"          : os.getenv("DATABASE_USER"),
    "password"      : os.getenv("DATABASE_PASS"),
    "db"            : "camagru",
    "charset"       : 'utf8',
    "autocommit"    : True,
    "cursorclass"   : DictCursor
}