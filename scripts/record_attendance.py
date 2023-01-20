#!/usr/bin/env python
import time
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
import Adafruit_CharLCD as LCD

db = mysql.connector.connect(
  host="localhost",
  user="gymadmin",
  passwd="loveyou",
  database="imaginery_gym"
)

cursor = db.cursor()
reader = SimpleMFRC522()

lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 4);

try:
  while True:
    lcd.clear()
    lcd.message('Place Card to\nenter')
    id, text = reader.read()

    cursor.execute("Select id, name FROM members WHERE rfid_uid="+str(id))
    result = cursor.fetchone()

    lcd.clear()

    if cursor.rowcount >= 1:
      lcd.message("Welcome " + result[1])
      cursor.execute("INSERT INTO attendance (user_id) VALUES (%s)", (result[0],) )
      db.commit()
    else:
      lcd.message("Member does not exist.")
    time.sleep(2)
finally:
  GPIO.cleanup()