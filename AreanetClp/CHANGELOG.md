# Changelog

## [2.0.0] - 2026-04-28
- Kompatibilität zu Shopware 6.7 (getestet gegen Core 6.7.9.0)
- composer `require shopware/core` auf `6.7.*` angehoben
- Geprüft gegen UPGRADE-6.7:
  - Native Property-Types in `AreanetClpTranslationEntity`, `AreanetClpGhsTranslationEntity` und `AreanetClpCommand` ergänzt
  - Rückgabewerte der Lazy-Association-Getter `getClp()` / `getClpGhs()` auf `?Entity` korrigiert
  - Keine weiteren Code-Anpassungen erforderlich (kein `setTwig`, keine Custom Entities, kein Payment-Handler, kein GenericPageLoader, keine `CustomerRegisterEvent`-Association-Zugriffe)

## [1.1.0]
- Letzte Version für Shopware 6.6
