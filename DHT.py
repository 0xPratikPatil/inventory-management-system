
import RPi.GPIO as GPIO
import sys
import datetime
import time
import Adafruit_DHT
import mysql.connector

db_config ={
"host" : "localhost",
"user" : "root",
"password" : "",
"database" : "ims"
}

GPIO.setmode(GPIO.BCM)
buzzer_pin = 3
GPIO.setup(buzzer_pin, GPIO.OUT)
threshold_temp = 28
threshold_humidity = 35
try:
    while True:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
    
        humidity, temperature = Adafruit_DHT.read_retry(11, 4)
        current_date = datetime.datetime.now().date()
        current_time = datetime.datetime.now().time()
        current_time = current_time.strftime("%H:%M")
        count = "SELECT COUNT(*) FROM status"
        cursor.execute(count)
        row_count = cursor.fetchone()[0] + 1

        if humidity > threshold_humidity or temperature > threshold_temp:
            GPIO.output(buzzer_pin,GPIO.HIGH)
        else:
            GPIO.output(buzzer_pin, GPIO.LOW)

        final_db = {
            "id":row_count,
            "current_date":current_date,
            "current_time":current_time,
            "humidity":humidity,
            "temperature":temperature
            }
        insert_query= "INSERT INTO status (id,cdate,ctime,humidity,temperature) VALUES (%(id)s,%(current_date)s,%(current_time)s,%(humidity)s,%(temperature)s)"
        cursor.execute(insert_query,final_db)
        conn.commit()

        cursor.close()
        conn.close()
        time.sleep(30)
        print("Done")
        print(humidity,temperature)

finally:
    print("Done")
    GPIO.cleanup()
