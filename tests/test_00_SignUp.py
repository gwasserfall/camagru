import os
import unittest
import requests

import pymysql
from tests import config

class TestSignUp(unittest.TestCase):

	def verify_email(self, email_address):
		pass

	def test_00_user_registration(self):
		r = requests.post(config.app_url + "/signup/create", json={
			"email" 	 : "test_user@test.com",
			"handle" 	 : "testUser",
			"password" 	 : "testPa$$w0rd!1",
			"first_name" : "John Tester",
			"no_email" : True # No emails sent when testing
		})

		self.assertEqual(r.status_code, 200, "Registration failed")

	def test_01_user_in_database(self):
		db = pymysql.connect(**config.database)

		with db.cursor() as c:
			c.execute("SELECT * FROM users WHERE email = 'test_user@test.com'")
			result = c.fetchall()
			
		self.assertEqual(len(result), 1)



	def test_02_user_registration_duplication_fails(self):
		r = requests.post(config.app_url + "/signup/create", json={
			"email" 	 : "test_user@test.com",
			"handle" 	 : "testUser",
			"password" 	 : "testPa$$w0rd!1",
			"first_name" : "John Tester"
		})

		response = r.json()

		self.assertEqual(False, response["success"], r.json())

