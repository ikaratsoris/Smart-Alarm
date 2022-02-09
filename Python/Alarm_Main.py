from gpiozero import LED, Button, Buzzer, Servo, MotionSensor
from time import sleep
import pycurl, json
from StringIO import StringIO
import psycopg2
import sys

buzzer0 = Buzzer(17)
servo0 = Servo(12)
servo1 = Servo(13)
msensor0 = Button(15)
msensor1 = Button(24)
msensor2 = Button(25)
msensor3 = Button(14)
msensor4 = Button(23)
pir0 = Button(4)
led_pir0 = LED(11)
led_servo0 = LED(5)
led_servo1 = LED(6)
led_locked = LED(2)
led_unlocked = LED(3)
led_msensor0 = LED(27)
led_msensor1 = LED(22)
led_msensor2 = LED(10)
led_msensor3 = LED(9)
led_msensor4 = LED(0)

def pressed(sensor):
    if lock_on==True:
        if sensor.pin.number==15:
            print("Magnet Sensor 1 Enabled")
            alarm_on()
            led_msensor0.on()
            lock_doors()
            buzzer()
            alarm_off()
            unlock_doors()
            led_msensor0.off()
        elif sensor.pin.number==24:
            print("Magnet Sensor 2 Enabled")
            alarm_on()
            led_msensor1.on()
            lock_doors()
            buzzer()
            alarm_off()
            unlock_doors()
            led_msensor1.off()
        elif sensor.pin.number==25:
            print("Magnet Sensor 3 Enabled")
            alarm_on()
            led_msensor2.on()
            lock_doors()
            buzzer()
            alarm_off()
            unlock_doors()
            led_msensor2.off()
        elif sensor.pin.number==14:
            print("Magnet Sensor 4 Enabled")
            alarm_on()
            led_msensor3.on()
            lock_door0()
            buzzer_door1()
            alarm_off()
            unlock_doors()
            led_msensor3.off()
        elif sensor.pin.number==23:
            print("Magnet Sensor 5 Enabled")
            alarm_on()
            led_msensor4.on()
            lock_door1()
            buzzer_door0()
            alarm_off()
            unlock_doors()
            led_msensor4.off()
        elif sensor.pin.number==4:
            print("Motion Sensor 0 Enabled")
            alarm_on()
            led_pir0.on()
            lock_doors()
            buzzer()
            alarm_off()
            unlock_doors()
            led_pir0.off()

def update_db():
    buzzer0.off()
    cur.execute("UPDATE alarm SET alarmactivated = False WHERE boardid = 0;")
    cur.execute("UPDATE alarm SET alarmalert = True WHERE boardid = 0;")
    conn.commit()
    c.perform()
    buzzer0.on()

def buzzer():
    buzzer0.on()
    update_db()
    cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
    [pswdCor] = cur.fetchone()
    buzzer0.off()
    while pswdCor==False:
        cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
        [pswdCor] = cur.fetchone()
        buzzer0.on()
        sleep(0.2)
        buzzer0.off()
        sleep(0.2)

def buzzer_door0():
    count0 = 0
    buzzer0.on()
    update_db()
    cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
    [pswdCor] = cur.fetchone()
    buzzer0.off()
    while pswdCor==False:
        cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
        [pswdCor] = cur.fetchone()
        buzzer0.on()
        sleep(0.2)
        buzzer0.off()
        if count0 == 10:
            sleep(0.2)
            lock_door_0()
        else:
            sleep(0.2)
        count0 = count0 + 1

def buzzer_door1():
    count1 = 0
    buzzer0.on()
    update_db()
    cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
    [pswdCor] = cur.fetchone()
    buzzer0.off()
    while pswdCor==False:
        cur.execute("SELECT pswdCorrect FROM alarm WHERE boardid = 0;")
        [pswdCor] = cur.fetchone()
        buzzer0.on()
        sleep(0.2)
        buzzer0.off()
        if count1 == 10:
            sleep(0.2)
            lock_door_1()
        else:
            sleep(0.2)
        count1 = count1 + 1

def alarm_on():
    led_locked.off()
    led_unlocked.on()

def alarm_off():
    led_unlocked.off()

def lock_doors():
    servo0.max()
    servo1.min()
    led_servo0.on()
    led_servo1.on()
    sleep(0.4)
    servo0.detach()
    servo1.detach()
    led_servo0.off()
    led_servo1.off()

def unlock_doors():
    servo0.min()
    servo1.max()
    led_servo0.on()
    led_servo1.on()
    sleep(0.4)
    servo0.detach()
    servo1.detach()
    led_servo0.off()
    led_servo1.off()

def lock_door0():
    servo0.max()
    led_servo0.on()
    sleep(0.4)
    servo0.detach()
    led_servo0.off()

def lock_door1():
    servo1.min()
    led_servo1.on()
    sleep(0.4)
    servo1.detach()
    led_servo1.off()

def lock_door_0():
    buzzer0.on()
    servo0.max()
    led_servo0.on()
    sleep(0.2)
    buzzer0.off()
    sleep(0.2)
    servo0.detach()
    led_servo0.off()

def lock_door_1():
    buzzer0.on()
    servo1.min()
    led_servo1.on()
    sleep(0.2)
    buzzer0.off()
    sleep(0.2)
    servo1.detach()
    led_servo1.off()

def sensor_conf():
    msensor0.when_released = pressed
    msensor1.when_released = pressed
    msensor2.when_released = pressed
    msensor3.when_released = pressed
    msensor4.when_released = pressed
    pir0.when_pressed = pressed

#main
servo0.detach()
servo1.detach()

#instapush
appID = "xxxxxxxxxxxxxx"
appSecret = "xxxxxxxxxxxxxx"
pushEvent = "xxxxxxxxxxxxxx"
pushMessage = "xxxxxxxxxxxxxx"
buffer = StringIO()
c = pycurl.Curl()
c.setopt(c.URL, 'https://api.instapush.im/v1/post')
c.setopt(c.HTTPHEADER, ['x-instapush-appid: ' + appID,
			'x-instapush-appsecret: ' + appSecret,
			'Content-Type: application/json'])

json_fields = {}
json_fields['event']=pushEvent
json_fields['trackers'] = {}
json_fields['trackers']['message']=pushMessage
postfields = json.dumps(json_fields)
c.setopt(c.POSTFIELDS, postfields)
c.setopt(c.WRITEFUNCTION, buffer.write)

#postgresql
conn_string = "host='localhost' dbname='xxxxxxxxxxxxxx' user='xxxxxxxxxxxxxx' password='xxxxxxxxxxxxxx'"
conn = psycopg2.connect(conn_string)
cur = conn.cursor()
print ("Connected to DB!")

cur.execute("UPDATE alarm SET shutdownalarm = False WHERE boardid = 0;")
conn.commit()
cur.execute("SELECT shutdownalarm FROM alarm WHERE boardid = 0;")
[shutdown] = cur.fetchone()

while shutdown==False:
    cur.execute("SELECT shutdownalarm FROM alarm WHERE boardid = 0;")
    [shutdown] = cur.fetchone()
    
    if shutdown==True:
        cur.close()
        conn.close()
        c.close()
        sys.exit()

    sleep(2)   

    cur.execute("SELECT alarmactivated FROM alarm WHERE boardid = 0;")
    [lock_on] = cur.fetchone()
    if lock_on==True:
        led_locked.on()
    elif lock_on==False:
        led_locked.off()
    sensor_conf()


