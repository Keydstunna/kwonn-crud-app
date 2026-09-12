<?php
// ===================================================================
// APP.PHP — Isang lugar lang para sa BASE_URL ng buong project
// -------------------------------------------------------------------
// Laragon has 2 common setups, kaya dalawang paraan mag-access:
//
//   A) http://localhost/event-registration-system/  (default XAMPP-style)
//      -> BASE_URL should be '/event-registration-system'
//
//   B) http://event-registration-system.test/  (Laragon "Auto Virtual Hosts",
//      kapag nasa loob ng www/laragon folder mo ang project na ito)
//      -> BASE_URL should be '' (walang laman, kasi nasa root na siya)
//
// PALITAN LANG ITO KUNG PAANO MO BUBUKSAN ANG PROJECT:
// ===================================================================

define('BASE_URL', '/event-registration-system');   // <-- Option A (default)
// define('BASE_URL', '');                            // <-- i-uncomment ito, i-comment yung taas, kung Option B
