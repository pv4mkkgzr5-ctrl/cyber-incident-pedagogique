/**
 *  🛡️ CYBER-INCIDENT PLATFORM - SECURITY SIGNATURE
 *  ================================================
 *  Cette application est un projet pédagogique démonstratif.
 *  Développé dans le cadre du BTS SIO SLAM.
 *  
 *  Auteur : Mathys SIO
 *  
 *  ⚠️ AVERTISSEMENT DE SÉCURITÉ
 *  ------------------------------------------------
 *  L'audit de ce code est encouragé à des fins éducatives.
 *  Toute tentative d'intrusion malveillante sur une instance
 *  de production sera logguée et signalée.
 *  
 *  "Security is not a product, but a process."
 *  ================================================
 */

(function () {
    const styles = [
        'background: #0f2027;',
        'background: linear-gradient(to right, #0f2027, #203a43, #2c5364);',
        'color: #00ff00;',
        'padding: 20px;',
        'font-family: monospace;',
        'font-size: 14px;',
        'border-radius: 5px;'
    ].join('');

    const text = `
    🛡️ SECURITE ACTIVE 🛡️
    
    Système de gestion d'incidents cyber
    Version : 1.2.0 (Patched)
    
    [INFO] Traçabilité active (Logs)
    [INFO] Protection Brute-Force active
    [INFO] En attente d'instructions...
    `;

    console.log('%c' + text, styles);
    console.log("%c Développé par Mathys SIO - Futur Expert Cyber", "color: #00d2ff; font-weight: bold; font-family: sans-serif;");
})();
