/**
 * Wunderflats Hub — main.js
 */
(function () {
  'use strict';

  /* ── Mobile nav toggle ────────────────────────── */
  var toggle = document.getElementById('nav-toggle');
  var nav    = document.getElementById('primary-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* ── Sticky header shadow ─────────────────────── */
  var header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.style.boxShadow = window.scrollY > 10
        ? '0 2px 16px rgba(0,0,0,.15)'
        : 'none';
    }, { passive: true });
  }

  /* ── Audience tab switcher ────────────────────── */
  var tabs = document.querySelectorAll('.aud-tab');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = this.getAttribute('data-target');

      tabs.forEach(function (t) {
        t.classList.remove('on');
        t.setAttribute('aria-selected', 'false');
      });
      document.querySelectorAll('.aud-panel').forEach(function (p) {
        p.classList.remove('is-active');
      });

      this.classList.add('on');
      this.setAttribute('aria-selected', 'true');
      var panel = document.getElementById('panel-' + target);
      if (panel) panel.classList.add('is-active');
    });
  });

  /* ── Smooth anchor scroll ─────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

}());
