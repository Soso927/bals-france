<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 11px;
        color: #1e293b;
        background: #fff;
    }

    /* ── En-tête ── */
    .entete {
        background: #1a3a6b;
        color: white;
        padding: 20px 30px;
    }
    .entete table { width: 100%; border-collapse: collapse; }
    .entete td { vertical-align: middle; }
    .entete td.col-droite { text-align: right; width: 50%; }
    .logo-text { font-size: 26px; font-weight: 900; letter-spacing: 4px; }
    .sous-titre { font-size: 11px; margin-top: 4px; opacity: 0.8; }
    .reference  { font-size: 15px; font-weight: bold; }
    .date-gen   { font-size: 10px; opacity: 0.7; margin-top: 4px; }
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
        background: rgba(255,255,255,0.2);
        margin-top: 6px;
    }

    /* ── Corps ── */
    .corps { padding: 24px 30px; }

    .section       { margin-bottom: 16px; }
    .section-titre {
        background: #e8f0fb;
        border-left: 4px solid #1a3a6b;
        padding: 6px 12px;
        font-weight: bold;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1a3a6b;
        margin-bottom: 8px;
    }

    /* ── Grille contact / caractéristiques ── */
    table.grille { width: 100%; border-collapse: collapse; }
    table.grille td {
        padding: 5px 10px;
        border: 1px solid #e2e8f0;
        vertical-align: top;
    }
    table.grille td.label {
        width: 20%;
        font-weight: bold;
        background: #f8fafc;
        color: #475569;
    }

    /* ── Tableaux prises / alimentation ── */
    table.tableau { width: 100%; border-collapse: collapse; }
    table.tableau th {
        background: #1a3a6b;
        color: white;
        padding: 6px 10px;
        font-size: 10px;
        font-weight: bold;
        text-align: left;
    }
    table.tableau td {
        padding: 5px 10px;
        border: 1px solid #e2e8f0;
        font-size: 10px;
    }
    table.tableau tr:nth-child(even) td { background: #f8fafc; }

    /* ── Observations ── */
    .obs {
        background: #fefce8;
        border: 1px solid #fde68a;
        border-radius: 4px;
        padding: 10px 14px;
        font-style: italic;
        color: #78350f;
        font-size: 10px;
    }

    /* ── Mention légale ── */
    .mention {
        border-top: 1px solid #e2e8f0;
        padding-top: 10px;
        font-size: 9px;
        color: #94a3b8;
        text-align: center;
    }

    /* ── Pied de page fixe ── */
    .pied {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        border-top: 2px solid #1a3a6b;
        padding: 6px 30px;
        font-size: 9px;
        color: #94a3b8;
        text-align: center;
        background: #fff;
    }
    .pied strong { color: #1a3a6b; }
</style>
