<!-- Added actual footer content -->
<footer aria-label="Site footer" class="st-footer">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    /* Scoped footer styles to match header typography and alignment */
    .st-footer {
      font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: #ffffff;
      color: #6b7280; /* muted gray */
      padding: 28px 16px;
      box-sizing: border-box;
      border-top: 1px solid rgba(0,0,0,0.04);
    }
    .st-footer .container {
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }
    .st-footer .links {
      display: inline-flex;
      gap: 12px;
      align-items: center;
      justify-content: center;
      flex-wrap: nowrap;
      font-size: 13px;
      color: #374151;
    }
    .st-footer .links a {
      color: #374151;
      text-decoration: none;
      font-weight: 600;
      opacity: 0.95;
      padding: 2px 4px;
    }
    .st-footer .links a:hover { text-decoration: underline; opacity: 1; }
    .st-footer .sep {
      color: #9ca3af;
      font-size: 12px;
      padding: 0 6px;
    }
    .st-footer .copyright {
      margin-top: 10px;
      font-size: 12px;
      color: #9ca3af;
    }

    /* Very small screens keep spacing tidy */
    @media (max-width: 420px) {
      .st-footer .links { gap: 8px; font-size: 12px; }
    }
  </style>

  <div class="container">
    <nav class="links" aria-label="Footer links">
      <a href="/privacy.php">Privacy Policy</a>
      <span class="sep">•</span>
      <a href="/terms.php">Terms of Service</a>
      <span class="sep">•</span>
      <a href="/support.php">Support</a>
    </nav>

    <div class="copyright">©2025 Smart Trashbin. All rights reserved.</div>
  </div>
</footer>

</body>
</html>
