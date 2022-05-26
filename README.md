# Temat projektu: Panel administracyjny księgarni internetowej
## Specyfikacja projektu
### Cel projektu : Stworzenie interfesju użytkownika oraz łączenie aplikacji z bazą danych księgarni
#### Cele szczegółowe:
   1. Stworzenie funkcjonalnego interfejsu użytkownika.
   2. Łączenie aplikacji z bazą danych.
   3. Możliwość zarządzania bazą danych z poziomu panelu administratora.
   4. Opcje przeglądania produktów, realizacji zamówień z poziomu panelu klienta.
### Funkcjonalności:
   1. Logowanie do panelu poprzez podanie loginu oraz hasła, które będą zapisywane w bazie i sprawdzane z nią (konto klienta i konto administratora).
   2. Rejestracja nowego klienta.
   3. Wyświetlanie danych z poszczególnych encji bazy danych.
   4. Zarządzanie danymi (możliwości dodawania rekordów, modyfkiacji, usuwania).
   5. Możliwość zmiany danych logowania na koncie administratora i klienta oraz możliwość zmiany danych osobowych na koncie klienta.
   6. Kontrolowanie ilości produktów z poziomu konta administratora.
   7. Dokonywanie zamówień, przeglądanie złożonych zamówień, faktur z poziomu konta klienta.
   8. Nadawanie rabatów dla klientów zależących od ilości zamówionych produktów.
   9. Opcja wyszukiwania rekordów w tablech z wykorzystaniem pola wyszukującego po wpsianej frazie.
   10. Filtrowanie produktów przez użytkownika z poziomu konta klienta.
   11. Możliwość przechodzenia na samą górę strony, za pomocą pojawiającego się przycisku możliwiającego tę operację.
   12. Opcja dodawania produktów do koszyka (z poziomu konta klienta).
   13. Opcjonalna faktura w trakcie składania zamówienia.
   14. Przeglądanie faktur z poziomu konta administratora i konta klienta.
   15. Możliwość dodawania produktów do zamówienia przez administratora.
### Interfejs serwisu

   <details>
       <summary>Ekran główny </summary>

![panel_adm](https://user-images.githubusercontent.com/79647437/121525382-8d063a00-c9f8-11eb-8af6-b84ace2b4750.PNG)
<p>Strona główna panelu administratora</p>
	
![panel_kl](https://user-images.githubusercontent.com/79647437/121525666-eb331d00-c9f8-11eb-861c-5c6bb0f59dbf.PNG)
	![panel_kl2](https://user-images.githubusercontent.com/79647437/121525723-fbe39300-c9f8-11eb-9064-aa1c4823fba0.PNG)
<p>Strona główna panelu klienta</p>


   </details>
	<details>
       <summary>Ekran logowania</summary>

![admin_login](https://user-images.githubusercontent.com/79647437/115704734-03c57600-a36c-11eb-8908-93d2b89c8a11.PNG)
![client_login](https://user-images.githubusercontent.com/79647437/115704759-09bb5700-a36c-11eb-93c2-ba64a2785baf.PNG)

           <p>Panele umożliwiają zalogowanie się do konta administratora i klienta</p>
   </details>
   
   <details>
	<summary>Ekran rejestracji</summary>
	
![client_registration](https://user-images.githubusercontent.com/79647437/115704955-3f604000-a36c-11eb-9c7d-de4cf615c381.PNG)

	<p>Umożliwia zarejestrowanie się klienta do serwisu sklepu internetowego</p>	
   </details>
   
   <details>
	<summary>Ustawienia danych administratora</summary>
	
![ust_admin](https://user-images.githubusercontent.com/79647437/121769848-39196380-cb66-11eb-91ff-49b7dd8c1738.PNG)

	<p>Po przejściu na podstronę ustawienia ze strony głównej użytkownik może dokonać zmiany nazwy użytkownika oraz adresu e-mail</p>
![hasl_afmin](https://user-images.githubusercontent.com/79647437/121770109-ad083b80-cb67-11eb-8215-63b462fad7cc.PNG)
	<p>Pod formularzem znajduje się przycisk prowadzący do zmiany hasła, gdzie użytkownik może zmienić swoje hasło</p>
   </details>
   
   <details>
	<summary>Przykładowa sekcja w panelu administratora</summary>
	
![sek_kl](https://user-images.githubusercontent.com/79647437/121770132-cdd09100-cb67-11eb-97a6-e413eb5153ff.PNG)
	
![wyszuk](https://user-images.githubusercontent.com/79647437/121770136-d1fcae80-cb67-11eb-9600-2eb657c9e26f.PNG)

	<p>Istnieje możliwość wyszukiwania rekordów za pomocą pola do wyszukiwania wg zaznaczonych kryteriów, np. wg numeru klienta</p>
   </details>
   
   <details>
	<summary>Okno edycji - przykład edycji danych klienta (panel administratora)</summary>
	
![edycja](https://user-images.githubusercontent.com/79647437/121770219-5e0ed600-cb68-11eb-84b7-de1cdaf580dc.PNG)
	<p>Po zaznaczeniu opcji "Zmień ustawienia" pola edycji oraz przycisk do zatwierdzenia zmian zostaną odblokowane</p>
![adres](https://user-images.githubusercontent.com/79647437/121770304-de353b80-cb68-11eb-8182-8804135fcb26.PNG)
	<p>W przypadku edycji danych klienta jest możliwość edycji jego adresu. Do tej podstrony można przejść klikając przycisk "Zmień dane adresowe".</p>
	<p>Pole "Adres_zamieszkania" jest cały czas zablokowane, jest to podgląd aktualnego adresu klienta. Zmian dokonujemy zaznaczając opcję "Zmień ustawienia", wtedy 		odblokowane zostaną poniższe pola do uzupełnienia danych adresowych oraz przycisk do zatwierdzenia zmian.</p>
	
   </details>
 
   <details>
	<summary>Przykładowa sekcja "Książki" (panel administratora)</summary>
	
![ksiazki](https://user-images.githubusercontent.com/79647437/121770643-b8109b00-cb6a-11eb-99c8-4eb9da644456.PNG)
![dodawanie_ksiazki](https://user-images.githubusercontent.com/79647437/121770683-058d0800-cb6b-11eb-8458-d7d4ca057332.PNG)
	<p>Po kliknięciu przycisku "Dodaj rekord" użytkownik zostaje przeniesiony do podstrony dodawania danych do tabeli.</p>
	<p>W przypadku dodawania nowej książki użytkownik musi podać ścieżkę do folderu "htdocs" wybrać miniaturkę książki w rozszerzeniu .jpg oraz opis oraz fragment książki w rozszerzeniu .txt.</p>
![aut](https://user-images.githubusercontent.com/79647437/121771029-3b32f080-cb6d-11eb-8dab-2ac12c51144a.PNG)
![dod_autora](https://user-images.githubusercontent.com/79647437/121770892-62d58900-cb6c-11eb-93d3-3e02c65fd249.PNG)
	<p>Klikając przycisk "Autorzy", który mieści się w każdym rekordzie w tabeli "Książki" możemy zobaczyć autora/autorów danej książki, a także dodawać ich. Zabezpieczone jest również powielanie autorów w danej książce.</p>
	
   </details>
   
   <details>
	<summary>Przykładowa sekcja "Zamówienia" (panel administratora)</summary>
	
![sekcja_zam](https://user-images.githubusercontent.com/79647437/121771151-eb085e00-cb6d-11eb-9528-64f892b3c962.PNG)
	<p>Z poziomu podstrony "Zamówienia" możemy przenieść się do podstron ze szczegółami zamówienia oraz z fakturami. Przyciski umożliwiające przejście do tych podstron znajdują w każdym wierszu tabeli.</p>
![szczeg](https://user-images.githubusercontent.com/79647437/121771285-c2cd2f00-cb6e-11eb-84e5-67a8457514ca.PNG)
![dod_szczeg](https://user-images.githubusercontent.com/79647437/121771374-438c2b00-cb6f-11eb-8ebd-43ca617d848c.PNG)
![edycja_szczeg](https://user-images.githubusercontent.com/79647437/121771395-68809e00-cb6f-11eb-8a5a-71009362055d.PNG)
	<p>Szczegóły zamówienia. Administrator może dodawać, usuwać produkty w zamówieniu, a także edytować ich ilość.</p>
![faktury](https://user-images.githubusercontent.com/79647437/121771709-51db4680-cb71-11eb-979c-bd45320f7aa1.PNG)
	<p>Po kliknięciu przycisku "Faktura" użytkownik przechodzi do tabeli z fakturą, gdzie może pobrać fakturę w formacie .pdf klikając na jej numer.</p>
![przykl_faktura](https://user-images.githubusercontent.com/79647437/121771832-2ad14480-cb72-11eb-9893-5e00e452fa72.PNG)
	<p>Powyżej przykładowa faktura</p>
	
   </details>
   
   <details>
	<summary>Ustawienia danych klienta</summary>
	
![kl_ust1](https://user-images.githubusercontent.com/79647437/121771989-fa3dda80-cb72-11eb-8329-f9987122eed5.PNG)
![kl_ust2](https://user-images.githubusercontent.com/79647437/121771992-ff028e80-cb72-11eb-8c8b-78b40f4393b5.PNG)
![kl_ust3](https://user-images.githubusercontent.com/79647437/121771994-01fd7f00-cb73-11eb-9e4d-b7045559ad18.PNG)
	<p>Do ustawień przechodzimy klikając w odnośnik "Moje ustawienia" znajdujący się na stronie głównej panelu klienta. Aby dokonać zmiany adresu bądź hasła, należy kliknąć w odpowiedni przycisk znajdujący się na samym dole zaraz po przejściu do ustawień.</p>
	
   </details>
   
   <details>
	<summary>Przeglądanie książek (panel klienta)</summary>
	
![przegladanie](https://user-images.githubusercontent.com/79647437/121772190-30c82500-cb74-11eb-9e90-54e09e705f87.PNG)
	<p>Aby móc przeglądać książki, należy rozwinąć opcję "Książki" w górnym pasku i wybrać opcję "Wszystkie" lub przeglądać wg kategorii.</p>
![filtr1](https://user-images.githubusercontent.com/79647437/121772265-a207d800-cb74-11eb-87a6-00815b28da85.PNG)
![filtr](https://user-images.githubusercontent.com/79647437/121772242-87356380-cb74-11eb-983c-dce51b3a0a00.PNG)
	<p>Z lewej strony znajdują się opcje filtrowania produktów</p>
![podglad](https://user-images.githubusercontent.com/79647437/121772298-d2e80d00-cb74-11eb-80b6-fc64739dbbed.PNG)
	<p>Po kliknięciu na miniaturkę wybranej książki użytkownik ma możliwość przeczytania opisu książki oraz pobrania jej fragmentu w formacie .pdf</p>
	
   </details>
   
   <details>
	<summary>Widok koszyka (panel klienta)</summary>
	
![koszyk](https://user-images.githubusercontent.com/79647437/121772436-a2ed3980-cb75-11eb-8b99-1855dc17e14e.PNG)
	<p>Po dodaniu produktu do koszyka użytkownik zostaje przekierowany do koszyka. Może tam zmieniać ilości swoich produktów, bądź usuwać je z koszyka.</p>
	
   </details>
   
   <details>
	<summary>Składanie zamówienia (panel klienta)</summary>
	
![koszyk](https://user-images.githubusercontent.com/79647437/121772436-a2ed3980-cb75-11eb-8b99-1855dc17e14e.PNG)
	<p>Widok koszyka.</p>
![podsumowanie](https://user-images.githubusercontent.com/79647437/121772525-21e27200-cb76-11eb-8799-023bca14b19c.PNG)
	<p>Po kliknięciu przycisku "Przejdź dalej" na ekranie pojawi się podsumowanie zakupów.</p>
![koniec](https://user-images.githubusercontent.com/79647437/121772586-7ede2800-cb76-11eb-8bc5-f8c02dddd6da.PNG)
	<p>Po kliknięciu przycisku "Dalej" pojawia się okno, w którym trzeba wybrać metodę płatności oraz opcjonalnie fakturę do zamówienia.</p>
![zlozone](https://user-images.githubusercontent.com/79647437/121772625-bfd63c80-cb76-11eb-9163-10a9586b838e.PNG)
	
   </details>

   <details>
	<summary>Historia zamówień</summary>
	
![histora_zam](https://user-images.githubusercontent.com/79647437/121772752-bd281700-cb77-11eb-8f68-33f050d1672a.PNG)
![podgl_faktury](https://user-images.githubusercontent.com/79647437/121772845-68d16700-cb78-11eb-85f9-555cbbf6af43.PNG)
	<p>Użytkownik może przeglądać historię zamówień oraz faktury, które może sobie pobrać w formacie .pdf.</p>
	
   </details>
   
### Baza danych
####	Diagram ERD
![Schemat_bazy_danych](https://user-images.githubusercontent.com/79647437/121517256-6ee80c00-c9ef-11eb-93ba-16b468f02681.png)


####	Skrypt do utworzenia struktury bazy danych
Skrypt bazy danych znajduje się w pliku ksiegarnia_internetowa.sql

## Wykorzystane technologie
HTML, CSS, Bootstrap, JavaScript, AJAX, PHP, SQL

## Proces uruchomienia aplikacji (krok po kroku)
1. Przed uruchomieniem aplikacji należy sprawdzić pliki służące do połączenia się z bazą danych. Są to pliki connect.php znajdujące się w folderach:

![connect](https://user-images.githubusercontent.com/79647437/121776298-5e20cd00-cb8c-11eb-99b2-73f365d57372.PNG)

- Projektaplikacje\admin
- Projektaplikacje\admin\subpages
- Projektaplikacje\admin\subpages\dodawanie
- Projektaplikacje\admin\subpages\edycja
- Projektaplikacje\admin\subpages\usuwanie
- Projektaplikacje\admin\subpages\dodawanie

- Projektaplikacje\klient
- Projektaplikacje\klient\subpages
- Projektaplikacje\klient\subpages\dodawanie
- Projektaplikacje\klient\subpages\edycja
- Projektaplikacje\klient\subpages\usuwanie
- Projektaplikacje\klient\subpages\dodawanie


3. Aby aplikacja działała poprawnie należy zainstalować system zarządzania pakietami Composer. Instalację należy przeprowadzić w domyślnej ścieżce.
Instalacja composera w systemie Windows, sprowadza się do pobrania odpowiedniego pliku instalacyjnego oraz jego uruchomienia na naszym komputerze/serwerze.
UWAGA! Aby composer był widoczny, należy zresetować otwartą konsole.

Aby zainstalować Composera w systemach unixowyxh należy zrealizować następujące operacje:
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

Po wykonaniu tych operacji, należy jedynie sprawić żeby composer był widoczny globalnie na całym serwerze. Aby tego dokonać należy wykonać komendę:

mv composer.phar /usr/local/bin/composer

Link do Composer: https://getcomposer.org

4. Kiedy Composer jest już zainstalowany, należy uruchomić terminal, wjeść do: Projektaplikacje\admin\subpages, który ma się znajdować w foldrze htdocs i wpisać następujące polecenie: $ composer require mpdf/mpdf
5. Następnie należy powtórzyć poprzedni krok w ścieżce Projektaplikacje\klient\subpages w folderze htdocs.
6. Po uruchomieniu aplikacji wyświetla się panel logowania.
7. Należy podać dane logowania (login, hasło), w przypadku braku konta klienta, w dolnej części znajduje się przycisk przenoszący pod adres rejestracji.
8. Po udanym zalogowaniu wyświetla się strona główna aplikacji.
9. Z poziomu strony głównej poprzez menu można poruszać się po aplikacji.

### Potrzebne nazwy użytkowników do uruchomienia aplikacji
Panel administratora:
Użytkownik 1: Nazwa: admin1  Hasło: 1qazXSW@
Użytkownik 2: Nazwa: admin2  Hasło: zaq1@WSX

Panel klienta:
Przykładowy użytkownik: Nazwa: janek  Hasło: qwertyuiop
Powyższe hasło jest takie same dla pozostałych użytkowników w bazie daycnh.

[Przydatny link przy tworzeniu plików *.md ](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)

[logo]: https://gallery.dpcdn.pl/imgc/UGC/34567/g_-_960x640_-_s_x20131110194052_0.jpg "Strona główna"
