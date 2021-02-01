import os
from pymysql.cursors import DictCursor
from requests import Session

app_url = "http://localhost:8000"

session = Session()

red_square = b'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAIAAAACUFjqAAAAEklEQVR4nGP8z4APMOGVHbHSAEEsAROxCnMTAAAAAElFTkSuQmCC'
green_square = b'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAIAAAACDbGyAAAAEklEQVR4nGNkaGBABkwMDBTxASjgAIoeFJBRAAAAAElFTkSuQmCC'

database = {
    "host"          : os.getenv("DATABASE_URI"),
    "user"          : os.getenv("DATABASE_USER"),
    "password"      : os.getenv("DATABASE_PASS"),
    "db"            : "camagru",
    "charset"       : 'utf8',
    "autocommit"    : True,
    "cursorclass"   : DictCursor
}