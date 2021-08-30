// 2021, Mattia Mascarello, The MIT License
#include <SDS011.h>

float p10,p25;
int error,fumo,delayms;
SDS011 my_sds;


void setup() {


  
  my_sds.begin(10,11);
  Serial.begin(9600);

}

void loop() {
  
 while (Serial.available()==0){}
 delayms=Serial.parseInt();
 error = my_sds.read(&p25,&p10);
  if (! error) {
    Serial.println("p25,"+String(p25));
    Serial.println("p10,"+String(p10));
  }

  fumo = analogRead(0);
  Serial.println("smoke,"+String(fumo)); 
  delay(delayms);
}
