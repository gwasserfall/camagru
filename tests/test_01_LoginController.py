import os
import unittest
import requests
import pymysql

from hashlib import sha256
from tests import config
from tests.config import session

class TestLoginController(unittest.TestCase):

	def user_id(self, email):
		db = pymysql.connect(**config.database)
		with db.cursor() as c:
			c.execute("SELECT id FROM users WHERE email=%s", (email, ))
			return str(c.fetchone()["id"])
		return None


	def test_00_incorrect_login_403(self):
		"""Ensure login action with incorrect password fails with 401 status\n"""
		
		r = session.post("http://localhost:8000/login/authenticate", 
			json={"email" : "fakeemail@fakedomain.faketld", "password": "fakefake"})

		return self.assertEqual(r.status_code, 401)


	def test_01_correct_login_unverified(self):
		"""Ensure login action with unverified account returns success=False"""
		
		r = session.post("http://localhost:8000/login/authenticate", 
			json={"email" : "test_user@test.com", "password": "testPa$$w0rd!1", "no_email" : True})

		return self.assertEqual(r.json()["success"], False, r.json())


	def test_02_account_verification(self):
		"""Ensure login action with verified account returns 200 status"""

		# Generate and request verification link
		email_hash = sha256(b"test_user@test.com" + os.environ.get("SALT").encode("utf-8")).hexdigest()
		user_id = self.user_id("test_user@test.com")

		link = config.app_url + "/users/verify/" + user_id + "/" + email_hash

		r = session.get(link)

		self.assertFalse("<title>404</title>" in r.text, "404 page thrown, link is incorrect")


	def test_03_correct_login_verified(self):
		"""Ensure login action with unverified account returns 401"""
		
		r = session.post("http://localhost:8000/login/authenticate", 
			json={"email" : "test_user@test.com", "password": "testPa$$w0rd!1", "no_email" : True})

		return self.assertEqual(r.status_code, 200, r.json())
