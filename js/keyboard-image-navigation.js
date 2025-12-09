document.addEventListener('DOMContentLoaded', () => {
  const href = (selector) => {
    const el = document.querySelector(selector);
    return el ? el.getAttribute('href') : null;
  };

  document.addEventListener('keydown', (e) => {
    const active = document.activeElement;
    if (active && (active.tagName === 'INPUT' || active.tagName === 'TEXTAREA')) return;

    let url = null;
    const key = e.key.toLowerCase();

    switch (key) {
      case 'arrowleft':
      case 'k':
        url = href('.previous a');
        break;
      case 'arrowright':
      case 'j':
        url = href('.next a');
        break;
      case 'h':
        url = '/';
        break;
      case 'e':
        if (e.metaKey) {
          const editNode = document.getElementById('wp-admin-bar-edit');
          if (editNode) window.location.assign(editNode.firstChild.href);
          return;
        }
        break;
      case 'p':
        if (e.altKey && e.ctrlKey) url = href('a.post-parent');
        break;
      case 'r':
        if (!e.ctrlKey && !e.metaKey) { // avoid interfering with Cmd/Ctrl+R
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
});
