/**
 *  🛡️ CYBER-INCIDENT PLATFORM - SECURITY SIGNATURE
 *  Auteur : Mathys SIO
 */

(function () {
    const titleStyle = [
        'font-family: monospace',
        'font-weight: bold',
        'font-size: 16px',
        'color: #00ff00',
        'text-shadow: 1px 1px 0px black'
    ].join(';');

    const shieldArt = `
    
      .---.
     /     \\ 
    |  (o)  |   CYBER-INCIDENT
     \\     /    PROTECTED SYSTEM
      \`---\` 
    `;

    const warningText = `
    ⚠️  SYSTEME SOUS SURVEILLANCE
    --------------------------------
    Version : 1.2.0 (Secure)
    IP Loggée : Active
    Anti-Brute Force : Actif
    
    Développé par Mathys SIO
    Futur Expert Cyberdéfense
    `;

    console.log(`%c${shieldArt}`, "color: #00d2ff; font-weight: bold;");
    console.log(`%c${warningText}`, titleStyle);
})();
