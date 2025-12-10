document.addEventListener('DOMContentLoaded', () => {
  const href = (selector) => {
    const el = document.querySelector(selector);
    return el ? el.getAttribute('href') : null;
  };

  // Keyboard shortcut overlay
  const overlay = document.createElement('div');
  overlay.id = 'keyboard-shortcuts-overlay';
  overlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;align-items:center;justify-content:center;';
  overlay.innerHTML = `
    <div style="background:#1a1a1a;color:#e0e0e0;padding:2rem;border-radius:8px;width:400px;max-width:400px;max-height:80vh;overflow:auto;border:1px solid #333;">
      <h2 style="margin:0 0 1rem 0;color:#fff;">Keyboard Shortcuts</h2>
      <table style="width:100%;border-collapse:collapse;">
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">←</kbd> or <kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">K</kbd></td><td style="padding:0.5rem 0;">Previous image</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">→</kbd> or <kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">J</kbd></td><td style="padding:0.5rem 0;">Next image</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">H</kbd></td><td style="padding:0.5rem 0;">Home</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">R</kbd></td><td style="padding:0.5rem 0;">Random image</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">⌘E</kbd></td><td style="padding:0.5rem 0;">Edit post</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">⌥⌘P</kbd></td><td style="padding:0.5rem 0;">Post parent</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">⇧⌘L</kbd></td><td style="padding:0.5rem 0;">Login</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">⌘/</kbd></td><td style="padding:0.5rem 0;">Toggle shortcuts</td></tr>
        <tr><td style="padding:0.5rem 1rem 0.5rem 0;text-align:right;vertical-align:top;"><kbd style="background:#333;color:#fff;padding:0.2em 0.4em;border-radius:3px;font-family:monospace;">Esc</kbd></td><td style="padding:0.5rem 0;">Close</td></tr>
      </table>
    </div>
  `;
  document.body.appendChild(overlay);

  const showOverlay = () => {
    overlay.style.display = 'flex';
  };
  const hideOverlay = () => {
    overlay.style.display = 'none';
  };

  document.addEventListener('keydown', (e) => {
    // Toggle overlay with Cmd+/ or Ctrl+/
    if (e.key === '?') {
      e.preventDefault();
      if (overlay.style.display === 'flex') {
        hideOverlay();
      } else {
        showOverlay();
      }
      return;
    }

    // Hide overlay with Esc
    if (e.key === 'Escape' && overlay.style.display === 'flex') {
      e.preventDefault();
      hideOverlay();
      return;
    }

    const active = document.activeElement;
    if (active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA')) return;

    let url = null;
    const key = e.key.toLowerCase();

    switch (key) {
      case 'arrowleft':
      case 'k':
        if (!e.ctrlKey && !e.metaKey) {
          url = href('.previous a');
        }
        break;
      case 'arrowright':
      case 'j':
        if (!e.ctrlKey && !e.metaKey) {
          url = href('.next a');
        }
        break;
      case 'h':
        url = '/';
        break;
      case 'e':
          const editNode = document.getElementById('wp-admin-bar-edit');
          if (editNode) window.location.assign(editNode.firstChild.href);
        break;
      case 'p':
        if (e.altKey && e.ctrlKey) url = href('a.post-parent');
        break;
      case 'r':
        if (!e.ctrlKey && !e.metaKey) {
          const link = document.getElementById('rollthedice');
          if (link) {
            e.preventDefault();
            url = link.getAttribute('href');
          }
        }
        break;
      case 'l':
        if (e.shiftKey && e.ctrlKey) {
          window.location = `${keyboard_navigation_args.home_url}/wp-login.php?redirect_to=${document.URL}`;
          return;
        }
        break;
    }

    if (url) window.location.href = url;
  });

  // Close overlay when clicking outside
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) hideOverlay();
  });
});
