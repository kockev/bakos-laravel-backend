# Bakos Docker Environment - Backend

## Tartalomjegyzék

1. [Modell Hierarchia](#modell-hierarchia)
2. [Nova Admin Felhasználói Kézikönyv](#nova-admin-felhasználói-kézikönyv)
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
🏢 Company (Root Entity)
└── 🏫 Institution (belongs to Company)
    └── 👨‍🎓 Student (belongs to Institution)
        └── 🥗 Diet (Student belongs to Diet)
            └── 📋 Menu (Diet has many Menus)
                └── 🍽️ Food (Menu contains many Foods)
```

### Részletes Kapcsolatok

#### **1. Cég → Intézmény**
- **Cég** (Company) → **Intézmény** (Institution) - Egy-a-többhöz kapcsolat
- Egy cég több intézményt kezelhet
- Egy intézmény egy céghez tartozik

#### **2. Intézmény → Diák**
- **Intézmény** (Institution) → **Diák** (Student) - Egy-a-többhöz kapcsolat
- Egy intézmény több diákot fogadhat
- Egy diák egy intézményhez tartozik

#### **3. Diák → Diéta**
- **Diák** (Student) → **Diéta** (Diet) - Több-a-egyhez kapcsolat
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

1. **Cégek** több **Intézményt** kezelnek (iskolák/oktatási intézmények)
2. Minden **Intézmény** több **Diákot** fogad
3. Minden **Diák** egy specifikus **Diétát** követ (táplálkozási követelmények)
4. Minden **Diéta** több **Menüvel** kompatibilis (különböző étkezési tervek)
5. Minden **Menü** több **Ételt** tartalmaz (tényleges élelmiszerek)

---

## Nova Admin Felhasználói Kézikönyv

### Áttekintés

A Nova admin felület a következő fő menüpontokból áll:

- **Company Management** (Cégkezelés)
- **Student Management** (Diákkezelés)
- **Nutrition Management** (Táplálkozáskezelés)
- **Order Management** (Rendeléskezelés)

---

## Cégkezelés

### 1. Cégek (Companies)

#### Új cég létrehozása:
1. Navigálj a **Company Management** → **Companies** menüpontra
2. Kattints a **"Create Company"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Cím** (Address)
   - **Kapcsolattartó** (Contact Person)
   - **Email**
   - **Telefon** (Phone)
4. Kattints a **"Create"** gombra

#### Cég szerkesztése:
1. A cégek listájában kattints a szerkeszteni kívánt cégre
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

#### Cég törlése:
1. A cég részletei oldalon kattints a **"Delete"** gombra
2. Erősítsd meg a törlést

---

## Intézménykezelés

### 2. Intézmények (Institutions)

#### Új intézmény létrehozása:
1. Navigálj a **Company Management** → **Institutions** menüpontra
2. Kattints a **"Create Institution"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Cég** (Company) - kötelező, válassz egy céget a listából
   - **Cím** (Address)
4. Kattints a **"Create"** gombra

#### Intézmény szerkesztése:
1. Az intézmények listájában kattints a szerkeszteni kívánt intézményre
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

#### Intézmény törlése:
1. Az intézmény részletei oldalon kattints a **"Delete"** gombra
2. Erősítsd meg a törlést

---

## Diákkezelés

### 3. Diákok (Students)

#### Új diák hozzáadása:
1. Navigálj a **Student Management** → **Students** menüpontra
2. Kattints a **"Create Student"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Intézmény** (Institution) - kötelező, válassz egy intézményt
   - **Név** (Name) - kötelező
   - **Diéta** (Diet) - kötelező, válassz egy diétát
   - **Korosztály** (Age Group) - kötelező
   - **Étkezési preferenciák** (Meal Preferences) - kötelező
4. Opcionális mezők:
   - **Diéta igazolás érvényes -ig** (Diet Certificate Valid Until)
   - **Inaktív -tól** (Inactive From)
   - **Inaktív -ig** (Inactive To)
5. Kattints a **"Create"** gombra

#### Diák szerkesztése:
1. A diákok listájában kattints a szerkeszteni kívánt diákra
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

#### Diák törlése:
1. A diák részletei oldalon kattints a **"Delete"** gombra
2. Erősítsd meg a törlést

#### Vendég felhasználók (Guest Users):
- Vendég felhasználók csak a saját intézményük diákjait láthatják
- Csak a hiányzási időszakokat (Inactive From/To) szerkeszthetik
- A többi mező csak olvasható

---

## Táplálkozáskezelés

### 4. Diéták (Diets)

#### Új diéta létrehozása:
1. Navigálj a **Nutrition Management** → **Diets** menüpontra
2. Kattints a **"Create Diet"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Leírás** (Description)
   - **Hozzárendelt menük** (Assigned Menus) - kötelező, válassz menüket
4. Kattints a **"Create"** gombra

#### Diéta szerkesztése:
1. A diéták listájában kattints a szerkeszteni kívánt diétára
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

### 5. Menük (Menus)

#### Új menü létrehozása:
1. Navigálj a **Nutrition Management** → **Menus** menüpontra
2. Kattints a **"Create Menu"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Leírás** (Description)
   - **Dátum** (Date) - kötelező
   - **Hozzárendelt ételek** (Assigned Foods) - kötelező
4. Minden hozzárendelt ételhez meg kell adni:
   - **Étkezés típusa** (Meal Type) - kötelező
5. Kattints a **"Create"** gombra

#### Menü szerkesztése:
1. A menük listájában kattints a szerkeszteni kívánt menüre
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

### 6. Ételek (Foods)

#### Új étel hozzáadása:
1. Navigálj a **Nutrition Management** → **Foods** menüpontra
2. Kattints a **"Create Food"** gombra
3. Töltsd ki a kötelező mezőket:
   - **Név** (Name) - kötelező
   - **Kód** (Code) - kötelező, egyedi kell legyen
4. Opcionális mezők:
   - **Összetevők** (Ingredients)
   - **Allergének** (Allergens)
5. Kattints a **"Create"** gombra

#### Étel szerkesztése:
1. Az ételek listájában kattints a szerkeszteni kívánt ételre
2. Kattints a **"Edit"** gombra
3. Módosítsd a szükséges mezőket
4. Kattints a **"Update"** gombra

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

#### Kétfaktoros hitelesítés visszaállítása:
- A felhasználó részletei oldalon kattints a **"Reset two-factor auth"** gombra

---

## Hasznos tippek

1. **Keresés**: Minden listázó oldalon használhatod a keresőmezőt a gyorsabb navigáláshoz
2. **Szűrés**: A listákban rendezhetsz oszlopok szerint
3. **Törlés**: A törlés művelet nem vonható vissza, ezért légy óvatos
4. **Jogosultságok**: A vendég felhasználók csak korlátozott funkciókhoz férnek hozzá
5. **PDF generálás**: A rendelések és konyha rendelések PDF formátumban letölthetők

---

## Hibaelhárítás

### Gyakori problémák:

1. **"Required field" hiba**: Ellenőrizd, hogy minden kötelező mezőt kitöltöttél
2. **"Unique constraint" hiba**: A kód vagy email már létezik, használj másikat
3. **Nincs jogosultság**: Ellenőrizd a felhasználói szerepkörödet
4. **Nem található oldal**: Frissítsd a böngészőt vagy ellenőrizd az internetkapcsolatot

Ha további segítségre van szükséged, fordulj a rendszergazdához.

---

## Technikai információk

- **Framework**: Laravel
- **Admin Panel**: Laravel Nova
- **Adatbázis**: SQLite
- **PHP verzió**: 8.1+
- **Docker**: Támogatott

### Telepítés

```bash
# Függőségek telepítése
composer install

# Adatbázis migrálása
php artisan migrate

# Adatbázis feltöltése
php artisan db:seed

# Nova admin elérése
http://localhost/nova
```