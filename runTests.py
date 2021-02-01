import os
import re
import pymysql

from pymysql.cursors import DictCursor

from tests import config

username, password, host, salt = [False] * 4

with open("./app/Config/Config.php", "r") as f:
	for line in f.readlines():
		if "DATABASE_URI" in line:
			host = re.findall(r'"(.*?)"', line)[1]
			os.environ["DATABASE_URI"] = host
		if "DATABASE_USER" in line:
			username = re.findall(r'"(.*?)"', line)[1]
			os.environ["DATABASE_USER"] = username
		if "DATABASE_PASS" in line:
			password = re.findall(r'"(.*?)"', line)[1]
			os.environ["DATABASE_PASS"] = password
		if "SALT" in line:
			salt = re.findall(r'"(.*?)"', line)[1]
			os.environ["SALT"] = salt


if not all([username, password, host, salt]):
	print("Database setup is not correct")
	quit()


os.system("python3 -m unittest discover -s tests")


# Clean UP after test

db = pymysql.connect(
	host=host,
	user=username,
	password=password,
	database='camagru',
	charset='utf8mb4',
	cursorclass=DictCursor,
	autocommit=True
)

# with db.cursor() as c:

# 	# Delete test user
# 	c.execute("DELETE FROM users WHERE email='test_user@test.com';")
