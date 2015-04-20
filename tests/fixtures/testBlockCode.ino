int temp;

void procedure() {
  temp = analogRead(A1);
  if (temp < 100) {
    digitalWrite(7,HIGH);

  } else {
    digitalWrite(7,LOW);

  }
}

void setup()
{
  pinMode(7, OUTPUT);
}


void loop()
{

}