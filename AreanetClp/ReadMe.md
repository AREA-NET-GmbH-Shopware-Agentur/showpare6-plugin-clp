# AreanetClp – CLP-Plugin für Shopware 6

Stellt CLP-Gefahrstoffhinweise (GHS-Piktogramme, H-/EUH-/P-Sätze inkl. Signalwörtern) als Stammdaten und Produktzuweisung in Shopware 6 zur Verfügung.

## Funktionsumfang
- Eigene Stammdaten-Module für CLP-Sätze (`areanet_clp`) und GHS-Piktogramme (`areanet_clp_ghs`) inkl. Übersetzungen
- Many-to-Many-Zuweisung zwischen Produkt und CLP-Sätzen (Produkt-Detail-Tab im Adminbereich)
- Storefront-Anzeige im Produkt-Detail (über Buy-Widget und unterhalb der Produktbeschreibung), Anzeigemodus „Kurzübersicht" oder „Komplett" pro Position konfigurierbar
- Initialer CSV-Datenimport für GHS-Piktogramme sowie H-/EUH-/P-Sätze (DE/EN) bei Plugin-Aktivierung
- Konsole-Befehl `bin/console areanet:clp:install` zum manuellen Re-Import der Stammdaten
- Ein- und ausschaltbare Anzeige von Piktogramm-Namen, Satz-Namen und Satz-Überschriften

## Unterstützte Shopware-Versionen
- **Shopware 6.7.x** (ab Plugin-Version 2.0.0, getestet gegen Core 6.7.9.0)
- Shopware 6.6.x: Plugin-Version 1.x (siehe 6.6-Branch / Repository-Stand vor 2.0.0)

## Installation
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

## Hersteller
[Area-Net GmbH](https://www.area-net.de)

---
Stand: 2026-04-28
