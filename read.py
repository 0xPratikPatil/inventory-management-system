

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector

reader = SimpleMFRC522()
db_config ={
"host" : "localhost",
"user" : "root",
"password" : "",
"database" : "ims"
}
try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        data =  reader.read()
        tagid = str(data[0])
       
        print(data)
    

        try:
                TAGID = {"TAGID":tagid}
                delete_query= f"DELETE FROM products WHERE tagid = {tagid}"

                cursor.execute(delete_query,TAGID)
                conn.commit()
        finally:
                print(f"No Entry Found With Tag ID :{tagid}, No Deletion Perform")

        cursor.close()
        conn.close()
        
finally:
        GPIO.cleanup()
