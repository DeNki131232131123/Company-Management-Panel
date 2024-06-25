Jest to mój pierwszy projekt szkoleniowy oraz wizytówka moich umiejętności pisania kodu PHP. Projekt miał na celu
 pokazanie mojej wiedzy z zakresu tablic, pętli oraz plików cookies. Moje skupienie było na kodzie a nie bezpieczeństwie kodu.
Wszystkie hasła są jawne, nie są zabezpieczone, połączenia z bazą danych są prowizoryczne omijając zabezpieczenia przed injectorami,
 ponieważ nie to było moim założeniem, a robiąc to skłamał bym że to potrafię.
Do pisania strony używałem pomocnych narzędzi, głównie ChatGPT gdzie pomagał mi znaleźć błędy, które występowały w kodzie a 
sam nie mogłem ich dojrzeć(głównie znaczniki oraz literówki, czasem też problemy logiczne, ponieważ wymyślając logikę nie zawsze
pamiętałem o poprawnościach zmiennych, o dobrym ułożeniu kolejności poleceń by nie kolidowały ze sobą). 


Strona ma 2 części, użytkownik, oraz robocza nazwa Menadżer. W panelu użytkownika głównym celem jest odczytanie treści jaką dodał
administrator strony lub przełożony. Po zalogowaniu się na konto Administratora, pokazuje się opcja zarządzania, na której możemy dodawać
użytkowników, przydzielać im stanowiska. W kolejnym kafelku znajduje się zarządzanie użytkownikiem( Zmiana hasła, zmiana stanowiska oraz
 usunięcie pracownika). 
Będąc na podstronie zarządzania, pokazuje nam się kolejna opcja w Menu gdzie możemy zarządzać typowo treścią. 
Z bazy danych pobiera się lista zadań, oraz opcja dodawania nowych zadań. Z bazy danych pobierane są dane Pracownika, które wyświetlają 
się w checkboxach, które możemy wykorzystać do przydzielania poszczególnych osób do zadania. 

Plik Cookies tworzy sesję logowania która trwa 60 minut, po upłynięciu czasu, skrypt przekierowywuje użytkownika do ponownego zalogowania.