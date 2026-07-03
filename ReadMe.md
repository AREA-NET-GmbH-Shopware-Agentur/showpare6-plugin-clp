# AreanetClp – CLP-Plugin für Shopware 6

Stellt CLP-Gefahrstoffhinweise (GHS-Piktogramme, H-/EUH-/P-Sätze inkl. Signalwörtern) als Stammdaten und Produktzuweisung in Shopware 6 zur Verfügung.

## Funktionsumfang
- Eigene Stammdaten-Module für CLP-Sätze (`areanet_clp`) und GHS-Piktogramme (`areanet_clp_ghs`) inkl. Übersetzungen
- Many-to-Many-Zuweisung zwischen Produkt und CLP-Sätzen (Produkt-Detail-Tab im Adminbereich)
- Storefront-Anzeige im Produkt-Detail (über Buy-Widget und unterhalb der Produktbeschreibung), Anzeigemodus „Kurzübersicht" oder „Komplett" pro Position konfigurierbar
- Initialer CSV-Datenimport für GHS-Piktogramme sowie H-/EUH-/P-Sätze (DE/EN) bei Plugin-Aktivierung
- Konsole-Befehl `bin/console areanet:clp:install` zum manuellen Re-Import der Stammdaten
- Ein- und ausschaltbare Anzeige von Piktogramm-Namen, Satz-Namen und Satz-Überschriften

## Unterstützte Shopware-Versionen und Changelog

Stand 03.07.2026:
- **Shopware 6.7.x** (ab Plugin-Version 2.0.0, getestet gegen Core 6.7.9.0)
- Shopware 6.6.x: Plugin-Version 1.x (siehe 6.6-Branch)
- [CHANGELOG](CHANGELOG.md)

## Installation

### ZIP-Release

Download des entsprechenden ZIP-Files von der [Release-Seite](https://github.com/AREA-NET-GmbH-Shopware-Agentur/showpare6-plugin-clp/releases) und Installation/Upload in der Shopware-Administration unter Erweiterungen.

### Composer

`composer require areanet/areanet/plugin-clp`


### Konsole

```bash
bin/console plugin:refresh
bin/console plugin:install --activate AreanetClp
bin/console cache:clear
```

Bei Aktualisierung einer bestehenden 1.x-Installation:

```bash
bin/console plugin:update AreanetClp
bin/console cache:clear
```

## Konfiguration
Im Adminbereich unter `Erweiterungen → Meine Erweiterungen → AreanetClp → Konfigurieren`:
- **Globale Anzeige**: Piktogramm-Namen, Satz-Namen, Satz-Überschriften ein-/ausblenden
- **Produkt-Detailseite**: Anzeigemodus oberhalb (Buybox) und unterhalb (Produktbeschreibung) – jeweils `Ausgeblendet`, `Kurzübersicht` oder `Komplett`
- **Adminbereich**: CLP-Zuweisung im Produkt-Stammdatentab anzeigen

## Support

Wir bieten zu unseren Open-Source-Plugins kostenpflichtigen Support an

* [Online-Formular](https://www.area-net.de/kontakt)
* [shopware@area-net.de](mailto:shopware@area-net.de)

## Shopware Theme und Plugins

Neben kostenlosen Open-Source Shopware-Plugins bietet die Shopware-Agentur auch Themes und Plugins im Shopware-Store an:

- [aloha Theme](https://store.shopware.com/en/arean62788672693m/a-better-cms-theme-optimized-checkout-b2b-functions-flexibly-customizable.html) mit optimiertem Checkout
- [aloha CMS Elements](https://store.shopware.com/arean13931131788m/a-better-cms-elements-slider-bilder-html5-video-google-maps-vorher-nachher-bilder.html) mit umfangreichen Erweiterungen der Standard-Inhaltselemente
- [Pagespeed Booster](https://store.shopware.com/arean41766445685m/pagespeed-booster-paypal-und-externe-skripte-auf-der-startseite-deaktivieren.html) deaktiviert PayPal und Co. auf der Startseite
- [Optimierte Inhaltsbearbeitung](https://store.shopware.com/arean36129443353f/optimierte-inhaltsbearbeitung-inhalte-nur-im-designer-bearbeiten-inhalte-in-layout-uebertragen.html) für CMS-Seiten und Kategorien
- [HTTP-Auth](https://store.shopware.com/arean97586892435f/http-authentifizierung-fuer-verkaufskanaele.html) für Verkaufskanäle

## AREA-NET GmbH
Die AREA-NET GmbH ist Shopware Partner Agentur und Shopware Hersteller, sowie Pickware Partner aus dem Großraum Stuttgart in Baden-Württemberg/Deutschland.

**Adresse**\
Öschstrasse 33\
73072 Donzdorf

Telefon: +49 (0)7162 - 941140\
Mail: [shopware@area-net.de](mailto:shopware@area-net.de)\
Web: [www.area-net.de](https://www.area-net.de)

Mehr Informationen, Projektanfragen und Support gibt es auf der Website der [Shopware-Agentur AREA-NET GmbH](https://www.area-net.de).

**Follow us**

- https://linkedin.com/companyarea-net-gmbh-shopware-agentur
- https://www.facebook.com/area.net.gmbh
