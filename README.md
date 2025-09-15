## Tartalomjegyzék

1. [Modell Hierarchia](#modell-hierarchia)
2. [Nova Admin Felhasználói Kézikönyv](#nova-admin-felhasználói-kézikönyv)
   - [Bejelentkezés](#bejelentkezés)
   - [Áttekintés](#áttekintés)
   - [Cégkezelés](#cégkezelés)
   - [Intézménykezelés](#intézménykezelés)
   - [Diákkezelés](#diákkezelés)
   - [Táplálkozáskezelés](#táplálkozáskezelés)
   - [Rendeléskezelés](#rendeléskezelés)
   - [Felhasználókezelés](#felhasználókezelés)

---

## Modell Hierarchia

A rendszer modelljei a következő hierarchikus struktúrában kapcsolódnak egymáshoz:

```
🏢 Cég/Szervezet
└── 🏫 Intézmény
    └── 👨‍🎓 Diák
        └── 🥗 Diéta
            └── 📋 Menü
                └── 🍽️ Ételek
```

### Részletes Kapcsolatok

#### **1. Cég → Intézmény**
- **Cég/Szervezet** (Company) → **Intézmény** (Institution)
- Egy cég több intézményt kezelhet
- Egy intézmény egy céghez tartozik

#### **2. Intézmény → Diák**
- **Intézmény** (Institution) → **Diák** (Student)
- Egy intézmény több diákot fogadhat
- Egy diák egy intézményhez tartozik

#### **3. Diák → Diéta**
- **Diák** (Student) → **Diéta** (Diet)
- Egy diák egy specifikus diétát követ
- Egy diéta több diákhoz rendelhető

#### **4. Diéta → Menü**
- **Diéta** (Diet) → **Menü** (Menu) - Több-a-többhöz kapcsolat
- Egy diéta több menüvel kompatibilis
- Egy menü több diétához rendelhető

#### **5. Menü → Étel**
- **Menü** (Menu) → **Étel** (Food) - Több-a-többhöz kapcsolat
- Egy menü több ételt tartalmazhat
- Egy étel több menüben szerepelhet

### Üzleti Logika

1. **Cégek/Szervezetek** több **Intézményt** kezelnek (iskolák/oktatási intézmények)
2. Minden **Intézmény** több **Diákot** fogad
3. Minden **Diák** egy specifikus **Diétát** követ (táplálkozási követelmények)
4. Minden **Diéta** több **Menüvel** kompatibilis (különböző étkezési tervek)
5. Minden **Menü** több **Ételt** tartalmaz (tényleges élelmiszerek)

## Általános sorrend létrehozásnál:

1. **Cég/Szervezet** létrehozása
2. **Intézmény** létrehozása és hozzárendelése a **Cég/Szervezethez**
3. **Diéta** létrehozása
4. **Diák** létrehozása és hozzárendelése **Intézményhez** és **Diétához** (diéta nélkül nem lehet diákot létrehozni)
5. **Ételek** létrehozása
6. **Menü** létrehozása és az **Ételek* hozzárendelése a **Menühöz**
7. **Menü** hozzárendelése **Diétához**
8. **Rendelések** generálása.

Amikor a **Cég/Szervezetek**, **Intézmények**, **Diákok**, **Diéták** és az **Ételek** márf fel vannak véve a rendszerben akkor csak a **Menüket** kell managelni egy napon ami így néz ki:

1. **Menü** létrehozása és az **Ételek* hozzárendelése a **Menühöz**
2.  **Menü** hozzárendelése **Diétához**
3.  **Rendelések** generálása.

---

## Nova Admin Felhasználói Kézikönyv

### Bejelentkezés

A rendszerbe való bejelentkezéshez először az email címedet és jelszavadat kell megadnod. Ezután kötelező a kétlépcsős azonosítás (2FA), amely a következőképpen működik:
- Töltsd le a Google Authenticator alkalmazást a telefonodra a Play Áruházból (Android) vagy az App Store-ból (iPhone).
- Első bejelentkezéskor megjelenik egy QR-kód a képernyőn.
- Nyisd meg a Google Authenticator alkalmazást, és olvasd be a QR-kódot.
- Ezután a BakosApp bekerül az alkalmazásba, ahol mindig látható lesz egy 6 számjegyű kód.
- Minden bejelentkezéskor, a jelszó megadása után ezt a 6 jegyű kódot kell beírnod a rendszerbe.

Ez a kétlépcsős azonosítás segít megvédeni a fiókot illetéktelen felhasználóktól, arra az esetre, ha a jelszó kiszivárogna.


### Áttekintés

A Nova admin felület a következő fő menüpontokból áll:

- **Company Management** (Cégkezelés)
- **Student Management** (Diákkezelés)
- **Nutrition Management** (Táplálkozáskezelés)
- **Order Management** (Rendeléskezelés)

---

## Cég/Szervezet kezelés

### 1. Cégek (Companies)

#### Új cég/szervezet létrehozása:
1. Navigálj a **Company Management** → **Companies** menüpontra
2. Kattints a **"Create Company"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name)
   - **Cím** (Address)
   - **Kapcsolattartó** (Contact Person)
   - **Email** (Email)
   - **Telefon** (Phone)
4. Kattints a **"Create Company"** gombra.

A Cég/Szervezet részletes nézetében látható a hozzárendelt intézmények listája.

#### Cég szerkesztése:
1. A cégek listájában kattints a szerkeszteni kívánt cégre 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Company"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

#### Cég törlése:
1. A cég lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt cégre, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

---

## Intézménykezelés

### 2. Intézmények (Institutions)

#### Új intézmény létrehozása:
1. Navigálj a **Company Management** → **Institutions** menüpontra
2. Kattints a **"Create Institution"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name)
   - **Cég** (Company) - kötelező, válassz egy céget a listából (céghez hozzárendelés)
   - **Cím** (Address)
4. Kattints a **"Create Institution"** gombra

Az intézmény részletes nézetében látható a hozzárendelt gyerekek listája.

#### Intézmény szerkesztése:
1. Az intézmények listájában kattints a szerkeszteni kívánt intézményre 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Institution"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

#### Intézmény törlése:
1. Az intézmény lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt intzéményre, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

---

## Diákkezelés

### 3. Diákok (Students)

#### Új diák hozzáadása:
1. Navigálj a **Student Management** → **Students** menüpontra
2. Kattints a **"Create Student"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Intézmény** (Institution) - kötelező, válaszd ki a listából
   - **Név** (Name) - kötelező
   - **Diéta** (Diet) - kötelező, válaszd ki a listából
   - **Korosztály** (Age Group) - kötelező, válaszd ki a listából
   - **Étkezési preferenciák** (Meal Preferences) - kötelező, jelöld meg melyik étkezéseket kéri a diák
   - **Diéta igazolás érvényes -ig** (Diet Certificate Valid Until) - ha üresen hagyod azt jelenti, hogy soha nincsen lejárata
4. Kattints a **"Create Student"** gombra

#### Diák szerkesztése:
1. A diákok listájában kattints a szerkeszteni kívánt diákra 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Student"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

Szerkesztésnél van lehetőség beállítani a diák hiányzását **Inactive From/To**.

#### Diák törlése:
1. A diákok lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt diákra, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

---

## Táplálkozáskezelés (Nutrition Management)

### 4. Ételek (Foods)

#### Új étel hozzáadása:
1. Navigálj a **Nutrition Management** → **Foods** menüpontra
2. Kattints a **"Create Food"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Kód** (Code) - kötelező, egyedi kell legyen (nem lehet ismétlődés)
   - **Összetevők** (Ingredients)
   - **Allergének** (Allergens)
4. Kattints a **"Create Food"** gombra

#### Étel szerkesztése:
1. Az ételek listájában kattints a szerkeszteni kívánt ételre 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Food"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

#### Étel törlése:
1. Az ételek lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt ételre, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

### 5. Diéták (Diets)

#### Új diéta létrehozása:
1. Navigálj a **Nutrition Management** → **Diets** menüpontra
2. Kattints a **"Create Diet"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Leírás** (Description)
4. Kattints a **"Create Diet"** gombra

A Diéta részletes nézetében látható a hozzárendelt menük listája.

#### Menü hozzárendelése a Diétához
1. A diéták listájában kattints a kívánt diétára
2. A részletes nézetben az adatok alatt látható a diétához tartozó menük listája
3. Kattints az **Attach Menu** gombra, új menu hozzáadásához
4. Válaszd ki a listából a kívánt menüt
5. Kattints a **"Attach Menu"** gombra

#### Diéta szerkesztése:
1. A diéták listájában kattints a szerkeszteni kívánt diétára 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Diet"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

#### Diéta törlése:
1. A diéták lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt diétára, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

### 6. Menük (Menus)

#### Új menü létrehozása:
1. Navigálj a **Nutrition Management** → **Menus** menüpontra
2. Kattints a **"Create Menu"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Leírás** (Description)
   - **Dátum** (Date) - kötelező
4. Kattints a **"Create"** gombra

Célszerű a menüket egy adott napra elkészíteni és aszerint elnevezni vagy legalább a "description"-ben feltüntetni, könnyebb lesz a diétához hozzárendelésnél kiválasztani.
A Menü részletes nézetében látható a hozzárendelt ételek listája étkezések alapján.

#### Ételek hozzárendelése a Menühöz étkezések alapján
1. A menük listájában kattints a kívánt menüre
2. A részletes nézetben az adatok alatt látható a menühöz tartozó ételek listája
3. Kattints az **Attach Food** gombra, új étel hozzáadásához
4. Töltsd ki a kötelező mezőket:
    - **Hozzárendelt étel** (Assigned Food) - kötelező, listából válaszd ki az ételt
    - **Étkezés típusa** (Meal Type) - kötelező, listából válaszd ki, hogy az adott étel melyik étkezést tölti majd be
5. Kattints a **"Attach Food"** gombra
6. Ismételd meg azt, ameddig az összes étkezéshez nem rendeltél hozzá ételt a menüben

Tehát a menü tartalmazni fogja az adott napra szánt ételeket étkezések alapján, a menüket előre is el lehet készíteni.
Az adott diák azokat az ételeket fogja kapni, ami a diétája alapján az adott napon a menüben szerepel.

#### Menü szerkesztése:
1. A menük listájában kattints a szerkeszteni kívánt menüre 
    1. a. Vagy a szerkesztés ikonra a lista nézetben, akkor egyből a szerkesztésre ugrik
2. A részletes nézetben kattints a szerkesztés ikonra a jobb felső sarokban
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update Menu"** gombra
5. Ha nem akarsz módosítani kattints a **Cancel** gombra

#### Menü törlése:
1. A menük lista oldalon kattints a kuka ikonra
    1. a Vagy kattints a törölni kívánt menüre, utána a részletes nézetben a jobb felső sarokban a 3 pontra(...) kattintva válaszd ki a **Delete Resource**-t
3. Erősítsd meg a törlést

---

## Rendeléskezelés

### 7. Rendelések (Orders)

#### Új rendelés létrehozása:
1. Navigálj a **Order Management** → **Orders** menüpontra
2. Kattints a **"Create Order"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name)
   - **Intézmény** (Institution) - kötelező
4. A rendelés létrehozása után:
   - Hozzáadhatsz diákokat a rendeléshez
   - Megadhatod az ételek mennyiségét
5. Kattints a **"Create"** gombra

#### Rendelés szerkesztése:
1. A rendelések listájában kattints a szerkeszteni kívánt rendelésre
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

#### Rendelés PDF letöltése:
- **Kombinált PDF** (Combined PDF)
- **Nagy adag PDF** (Big Meal PDF)
- **Kis adag PDF** (Small Meal PDF)

### 8. Konyha rendelések (Kitchen Orders)

#### Új konyha rendelés létrehozása:
1. Navigálj a **Order Management** → **Kitchen Orders** menüpontra
2. Kattints a **"Create Kitchen Order"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name)
4. A konyha rendelés létrehozása után hozzáadhatod az ételeket
5. Kattints a **"Create"** gombra

#### Konyha rendelés PDF letöltése:
- **Nagy adag PDF** (Big Meal PDF)
- **Kis adag PDF** (Small Meal PDF)

---

## Felhasználókezelés

### 9. Felhasználók (Users)

#### Új felhasználó létrehozása:
1. Navigálj a **Users** menüpontra
2. Kattints a **"Create User"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name)
   - **Intézmény** (Institution) - kötelező
   - **Email**
   - **Jelszó** (Password)
   - **Szerepkör** (Role) - kötelező
4. Kattints a **"Create"** gombra

#### Felhasználó szerkesztése:
1. A felhasználók listájában kattints a szerkeszteni kívánt felhasználóra
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra
