import mysql.connector
import randominfo as ri
import random
import subprocess
import json
import time

"""
'101B','101A','101C','201A','201B','201C','801','901'
"""

def data():
    datas={}
    degree=['IT','CSE','EEE','ECE','Civil','Mech']
    datas['name']=ri.get_first_name()
    datas['cls']=random.choice(degree)
    datas['rollno']="820520"+ri.get_id()
    datas['fname']=ri.get_full_name()
    datas['state']="Tamil Nadu"
    datas['zipcode']=ri.get_id()
    datas['gender']=ri.get_gender(datas['name'])
    datas['phoneno']=ri.get_phone_number()
    datas['email']=datas['name']+"@gmail.com"
    return datas

def register():
    d=data()
    reg={}
    room_id=["101","201","301","401","501","601","701","101B","101A","101C","201A","201B","201C","801","901"]
    food_d=[1,2,3,4,5]
    reg['rollno']=d['rollno']
    reg['room']=random.choice(room_id)
    reg['fd']=random.choice(food_d)
    reg['stay']="2023-02-25 02:48:43.699937"
    reg['hostel_d']=random.choice(food_d)
    reg['gname']=d['fname']
    reg["grel"]="Father"
    reg['gnum']=ri.get_phone_number()
    reg['emergency']=ri.get_phone_number()
    reg['fees']=(reg['hostel_d'] * 9000) + (reg['fd'] * 2500)
    return reg

def get_pass_salt(password):
    exe=subprocess.check_output(["php","salt.php",password])
    data=json.loads(exe)
    return data

def insert_data():
    user=data()
    reg=register()
    pwd=user['name']+"@098"
    password=get_pass_salt(pwd)
    conn=mysql.connector.connect(host="127.0.0.1",user="root",password="root",database="myhostel")
    cursor=conn.cursor()

    update(reg['room'],reg['fees'])
    sql1=f"INSERT INTO `user` (`id`, `name`, `class`, `rollno`, `fname`, `state`, `zipcode`, `city`, `address`, `genter`, `phone`, `email`, `salt`, `password`, `token`) VALUES (NULL, '{user['name']}', '{user['cls']}', '{user['rollno']}', '{user['fname']}', '{user['state']}', '{user['zipcode']}', 'Thiruvarur', '1/132 kuvindakudi', '{user['gender']}', '{user['phoneno']}', '{user['email']}', '{password['salt']}', '{password['pass']}', '{password['token']}')"
    
    sql2=f"INSERT INTO `register` (`room_no`, `food`, `food_duration`, `duration`, `fees`, `rollno`, `gname`, `grelation`, `gnumber`, `emergency`) VALUES ('{reg['room']}', 'with', '{reg['fd']}', '{reg['hostel_d']}', '{reg['fees']}','{user['rollno']}','{user['fname']}', '{reg['grel']}', '{reg['gnum']}', '{reg['emergency']}')"

    cursor.execute(sql1)
    conn.commit()
    print(cursor.rowcount," record inserted.")

    cursor.execute(sql2)
    conn.commit()
    print(cursor.rowcount," record inserted.")

def update(room,fees):
    conn=mysql.connector.connect(host="127.0.0.1",user="root",password="root",database="myhostel")
    cursor=conn.cursor()
    getdata=f"SELECT * FROM room WHERE room_id='{room}'"
    cursor.execute(getdata)
    data=cursor.fetchall()
    person=data[0][1]
    available=data[0][2]
    tfees=data[0][3] + fees
    if available <= 0:
        print(f"{room} room is full")
        insert_data()
        exit(-1)
    else:
        upd=f"UPDATE room SET person='{person+1}',available='{max(available -1,0)}',fees='{tfees}' WHERE room_id='{room}'"
        cursor.execute(upd)
        conn.commit()
        print(f"{room} room is updated")


for i in range(50):
    insert_data()