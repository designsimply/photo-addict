document.addEventListener('DOMContentLoaded', () => {
  const href = (selector) => {
    const el = document.querySelector(selector);
    return el ? el.getAttribute('href') : null;
  };

  const isLoggedIn = () => document.getElementById('wpadminbar') !== null;

  // Track double escape
  let lastEscapeTime = 0;
  const ESCAPE_DOUBLE_TIME = 500;

  // Track g d sequence
  let lastGTime = 0;
  const G_SEQUENCE_TIME = 1000;

  // Keyboard shortcut overlay
  const overlay = document.createElement('div');
  overlay.id = 'keyboard-shortcuts-overlay';
  overlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;align-items:center;justify-content:center;';
  overlay.innerHTML = `
    <div style="background:#1a1a1a;color:#e0e0e0;padding:1.5rem;border-radius:8px;width:700px;max-width:90vw;max-height:85vh;overflow:auto;border:1px solid #333;font-size:0.9em;">
      <h2 style="margin:0 0 0.75rem 0;color:#fff;font-size:1.1em;">Keyboard Shortcuts</h2>
      <table style="width:100%;border-collapse:collapse;">
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">←</kbd> or <kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">K</kbd></td><td style="padding:0.25rem 0.5rem;">Previous image</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G D</kbd></td><td style="padding:0.25rem 0.5rem;">Dashboard</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">→</kbd> or <kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">J</kbd></td><td style="padding:0.25rem 0.5rem;">Next image</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G T</kbd></td><td style="padding:0.25rem 0.5rem;">Tools</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">/</kbd></td><td style="padding:0.25rem 0.5rem;">Home</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G M</kbd></td><td style="padding:0.25rem 0.5rem;">Media</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">R</kbd></td><td style="padding:0.25rem 0.5rem;">Random image</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G G</kbd></td><td style="padding:0.25rem 0.5rem;">Pages</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">E</kbd></td><td style="padding:0.25rem 0.5rem;">Edit post</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G C</kbd></td><td style="padding:0.25rem 0.5rem;">Comments</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">C</kbd></td><td style="padding:0.25rem 0.5rem;">Create new post</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G A</kbd></td><td style="padding:0.25rem 0.5rem;">Themes</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">P</kbd></td><td style="padding:0.25rem 0.5rem;">Post parent</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G P</kbd></td><td style="padding:0.25rem 0.5rem;">Plugins</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 0;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">Esc Esc</kbd></td><td style="padding:0.25rem 0.5rem;">Login/Dashboard</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G U</kbd></td><td style="padding:0.25rem 0.5rem;">Users</td>
        </tr>
        <tr>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">?</kbd></td><td style="padding:0.25rem 0.5rem;">Toggle shortcuts</td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">G S</kbd></td><td style="padding:0.25rem 0.5rem;">Settings</td>
        </tr>
        <tr>
          <td></td><td></td>
          <td style="padding:0.25rem 0.5rem 0.25rem 1rem;"><kbd style="background:#333;color:#fff;padding:0.15em 0.3em;border-radius:3px;font-family:monospace;font-size:0.85em;">Esc</kbd></td><td style="padding:0.25rem 0.5rem;">Close</td>
        </tr>
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
    // Toggle overlay with Shift+/ or ?
    if (e.key === '?') {
      e.preventDefault();
      if (overlay.style.display === 'flex') {
        hideOverlay();
      } else {
        showOverlay();
      }
      return;
    }

    // escape escape
    if (e.key === 'Escape') {
      if (overlay.style.display === 'flex') {
        e.preventDefault();
        hideOverlay();
        return;
      }
      const now = Date.now();
      if (now - lastEscapeTime < ESCAPE_DOUBLE_TIME) {
        e.preventDefault();
        if (isLoggedIn()) {
          window.location.href = `/wp-admin/`;
        } else {
          window.location.href = `/wp-login.php`;
        }
        return;
      }
      lastEscapeTime = now;
      return;
    }

    const active = document.activeElement;
    if (active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA')) return;

    let url = null;
    const key = e.key.toLowerCase();
    const now = Date.now();

    // Handle g sequence shortcuts
    const gSequences = {
      'd': '/wp-admin/',
      'i': '/wp-admin/edit.php',
      'n': '/wp-admin/post-new.php',
      'm': '/wp-admin/upload.php',
      'g': '/wp-admin/edit.php?post_type=page',
      'c': '/wp-admin/edit-comments.php',
      'a': '/wp-admin/themes.php',
      'p': '/wp-admin/plugins.php',
      'u': '/wp-admin/users.php',
      'l': '/wp-admin/tools.php',
      's': '/wp-admin/options-general.php'
    };
    if (key === 'g' && !e.ctrlKey && !e.metaKey && !e.altKey && !e.shiftKey && isLoggedIn()) {
      // Check if this is g g sequence
      if (now - lastGTime < G_SEQUENCE_TIME) {
        e.preventDefault();
        window.location.href = gSequences['g'];
        return;
      }
      // Otherwise, start a new sequence
      lastGTime = now;
      return;
    }
    if (gSequences[key] && !e.ctrlKey && !e.metaKey && !e.altKey && !e.shiftKey) {
      if (now - lastGTime < G_SEQUENCE_TIME) {
        e.preventDefault();
        window.location.href = gSequences[key];
        return;
      }
    }

    switch (key) {
      case 'arrowleft':
      case 'k':
        if (!e.ctrlKey && !e.metaKey && !e.altKey) {
          url = href('.previous a');
        }
        break;
      case 'arrowright':
      case 'j':
        if (!e.ctrlKey && !e.metaKey && !e.altKey) {
          const nextSpan = document.querySelector('span.next');
          if (nextSpan) {
            const link = nextSpan.querySelector('a');
            if (link) {
              e.preventDefault();
              window.location.href = link.getAttribute('href');
              return;
            }
          }
          if (document.body.classList.contains('home') || document.body.classList.contains('archive')) {
            // On home or archive page, do nothing for j/right arrow
            return;
          }
          url = href('.next a');
        }
        break;
      case 'p':
        if (!e.ctrlKey && !e.metaKey && !e.altKey) {
          const link = document.querySelector('a.post-parent')?.href;
          if (link) {
            e.preventDefault();
            window.location.href = link;
            return;
          }
        }
        break;
      case '/':
        if (!e.altKey && !e.ctrlKey && !e.metaKey) {
          url = '/';
        }
        break;
      case 'e':
        if (!e.ctrlKey && !e.metaKey && !e.altKey) {
          const editNode = document.getElementById('wp-admin-bar-edit');
          if (editNode) window.location.assign(editNode.firstChild.href);
        }
        break;
      case 'c':
        if (!e.ctrlKey && !e.metaKey && !e.altKey && isLoggedIn()) {
          url = `/wp-admin/post-new.php`;
        }
        break;
      case 'r':
        if (!e.ctrlKey && !e.metaKey && !e.altKey) {
          const link = document.getElementById('rollthedice')?.href;
          if (link) {
            e.preventDefault();
            window.location.href = link;
            return;
          }
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
