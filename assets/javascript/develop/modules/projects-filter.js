// modules/projects-filter.js
export function createProjectsFilter(root = document, opts = {}) {
  const filters = root.querySelector('[data-projects-filters]');
  const results = root.querySelector('[data-projects-results]');
  const loader = root.querySelector('[data-projects-loader]');
  const sentinel = root.querySelector('[data-infinite-sentinel]');

  if (!filters || !results) return null;
  if (!window.DE_PROJECTS?.ajaxUrl || !window.DE_PROJECTS?.nonce) return null;

  const {
    loadingClass = 'is-loading',
    activeClass = 'is-active',
    paramName = 'cat',
    rootMargin = '300px',
    onAfterReplace = null, // animate all items
    onAfterAppend = null,  // animate appended items
  } = opts;

  let abortCtrl = null;
  let observer = null;

  let currentTerm = '';
  let currentPage = 1;
  let maxPages = 1;
  let isLoading = false;

  const setActiveByTerm = (term) => {
    const btns = [...filters.querySelectorAll('[data-filter-term]')];
    const btn = btns.find((b) => (b.getAttribute('data-filter-term') || '') === (term || ''));
    btns.forEach((b) => b.classList.remove(activeClass));
    (btn || btns[0])?.classList.add(activeClass);
  };

  const updateUrlParam = (term) => {
    const url = new URL(window.location.href);
    if (term) url.searchParams.set(paramName, term);
    else url.searchParams.delete(paramName);
    window.history.replaceState({}, '', url);
  };

  const readUrlParam = () => {
    const url = new URL(window.location.href);
    return url.searchParams.get(paramName) || '';
  };

  const setLoading = (v) => {
    isLoading = v;
    results.classList.toggle(loadingClass, v);
    if (loader) loader.hidden = !v;
  };

  const ajax = async ({ term = '', paged = 1 }) => {
    if (abortCtrl) abortCtrl.abort();
    abortCtrl = new AbortController();

    const fd = new FormData();
    fd.append('action', 'filter_projects');
    fd.append('nonce', window.DE_PROJECTS.nonce);
    fd.append('term', term);
    fd.append('paged', String(paged));

    const res = await fetch(window.DE_PROJECTS.ajaxUrl, {
      method: 'POST',
      body: fd,
      signal: abortCtrl.signal,
      credentials: 'same-origin',
    });

    if (!res.ok) throw new Error(`AJAX failed: ${res.status}`);

    const json = await res.json();
    if (!json?.success) throw new Error(json?.data?.message || 'AJAX error');
    return json.data;
  };

  const stopObserver = () => {
    if (observer) {
      observer.disconnect();
      observer = null;
    }
  };

  const startObserver = () => {
    if (!sentinel) return;
    stopObserver();

    observer = new IntersectionObserver(
      (entries) => {
        const entry = entries[0];
        if (!entry?.isIntersecting) return;
        loadNextPage();
      },
      { root: null, rootMargin, threshold: 0 }
    );

    observer.observe(sentinel);
  };

  const loadFirstPage = async (term) => {
    if (isLoading) return;

    stopObserver();
    setLoading(true);

    try {
      const data = await ajax({ term, paged: 1 });

      results.innerHTML = data.html;

      currentTerm = term;
      currentPage = 1;
      maxPages = data.maxPages || 1;

      setActiveByTerm(term);
      updateUrlParam(term);

      if (typeof onAfterReplace === 'function') onAfterReplace(results);

      startObserver();
    } catch (err) {
      if (err?.name !== 'AbortError') console.warn('[ProjectsFilter]', err);
    } finally {
      setLoading(false);
    }
  };

  const loadNextPage = async () => {
    if (isLoading) return;
    if (currentPage >= maxPages) return;

    setLoading(true);

    try {
      const nextPage = currentPage + 1;
      const data = await ajax({ term: currentTerm, paged: nextPage });

      const temp = document.createElement('div');
      temp.innerHTML = data.html;

      const newNodes = [...temp.children];
      newNodes.forEach((n) => results.appendChild(n));

      currentPage = nextPage;
      maxPages = data.maxPages || maxPages;

      if (typeof onAfterAppend === 'function') onAfterAppend(results, newNodes);
    } catch (err) {
      if (err?.name !== 'AbortError') console.warn('[ProjectsFilter]', err);
    } finally {
      setLoading(false);
    }
  };

  const onClick = (e) => {
    const btn = e.target.closest('[data-filter-term]');
    if (!btn) return;

    e.preventDefault();

    const term = btn.getAttribute('data-filter-term') || '';
    if (term === currentTerm && currentPage === 1) return;

    loadFirstPage(term);
  };

  const init = async () => {
    filters.addEventListener('click', onClick);

    // Term inicial: URL param o data-term desde PHP
    const fromUrl = readUrlParam();
    const fromData = results.getAttribute('data-term') || '';
    const initialTerm = fromUrl || fromData || '';

    // IMPORTANTE: siempre cargamos por AJAX al entrar.
    await loadFirstPage(initialTerm);
  };

  init();

  return {
    destroy() {
      if (abortCtrl) abortCtrl.abort();
      filters.removeEventListener('click', onClick);
      stopObserver();
      results.classList.remove(loadingClass);
      if (loader) loader.hidden = true;
    },
  };
}
