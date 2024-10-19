

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import random
import mysql.connector

reader = SimpleMFRC522()
db_config ={
"host" : "127.0.0.1",
"user" : "root",
"password" : "",
"database" : "ims"
}


try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        database= [
        ["iphone","Electronic"],
        ["laptop","Electronic"],
        ["t-shirt","Clothing"],
        ["Jeans","Clothing"],
        ["Paracitamol","Medicinal"],
        ["Goggles","Accessories"],
        ["Bags","Accessories"],
        ["Purse","Accesories"],
        ["Crocin","Medicinal"]
        ]
        
        random_product = random.choice(database)
        name = random_product[0]        
        category = random_product[1]
        location=""        
        
        if category=="Electronic":
                location="A302"
        elif category == "Grossary":
                location = "C103"
        elif category=="Clothing":
                location="B977"
        elif category=="Medicinal":
                location="K333"
        elif category=="Accessories":
                location="G547"




        print("Now place your tag to verify TAG ID")
        tagid =  reader.read()
        tagid = int(tagid[0])

        count = "SELECT COUNT(*) FROM products"
        cursor.execute(count)
        row_count = cursor.fetchone()[0] + 1
        
        final_db= {
        "id":row_count,
        "tagid":tagid,
        "name":name,
        "category":category,
        "location":location
        }

        insert_query= "INSERT INTO products (id,tagid,p_name,p_cat,location) VALUES (%(id)s,%(tagid)s,%(name)s,%(category)s,%(location)s)"

        cursor.execute(insert_query,final_db)
        conn.commit()
        cursor.close()
        conn.close()

        print(random_product)
        reader.write(ascii(random_product))
        print("Written")
        
finally:
         GPIO.cleanup()
    
