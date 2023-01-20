#!/usr/bin/env python

import sys
import time
import datetime
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
import Adafruit_CharLCD as LCD

db = mysql.connector.connect(
  host="localhost",
  user="attendanceadmin",
  passwd="loveyou",
  database="attendancesystem"
)

cursor = db.cursor()
reader = SimpleMFRC522()
lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 4);

try:
  while True:
    lcd.clear()
    lcd.message('Place Card to\nregister')
    id, text = reader.read()
    cursor.execute("SELECT id FROM users WHERE rfid_uid="+str(id))
    cursor.fetchone()

    if cursor.rowcount >= 1:
      lcd.clear()
      lcd.message("Overwrite\nexisting user?")
      overwrite = input("Overwite (Y/N)? ")
      if overwrite[0] == 'Y' or overwrite[0] == 'y':
        lcd.clear()
        lcd.message("Overwriting user.")
        time.sleep(1)
        sql_insert = "UPDATE users SET name = %s WHERE rfid_uid=%s"
      else:
        continue;
    else:
      sql_insert = "INSERT INTO users (name, rfid_uid) VALUES (%s, %s)"
    lcd.clear()
    lcd.message('Registering...')
    new_name = ' '.join(sys.argv[1:])

    cursor.execute(sql_insert, (new_name, id))

    db.commit()

    expiry_months = int(input("Membership duration in month: "))
    expiry_date = datetime.datetime.now() + datetime.timedelta(days=30*expiry_months)
    expiry_date_str = expiry_date.date().strftime('%Y-%m-%d')
    cursor.execute("UPDATE users SET expiry_date = %s WHERE rfid_uid=%s", (expiry_date_str, id))
    db.commit()

    time.sleep(1.5)
    lcd.clear()
    lcd.message("Membership \n Registered!")
    print(f"Member {new_name} registered")
    time.sleep(2)
finally:
  GPIO.cleanup()