// ===================================================================
// EFFECTS.JS — mga JS effect na shared sa lahat ng pages
// -------------------------------------------------------------------
// Naka-comment bawat function kung ano ginagawa, para madaling
// ipaliwanag sa oral defense / demo.
// ===================================================================

/**
 * leafCanvas(canvasId)
 * ---------------------------------------------------------------
 * Gumaguhit ng mga lumulutang na "dahon" (simpleng ellipse + tangkay,
 * hindi image file) sa isang <canvas>. Ginagamit sa background ng
 * login page at ng dalawang event landing/hero section.
 * Pure Canvas 2D API lang, walang external library.
 */
function leafCanvas(canvasId, opts = {}) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const count = opts.count || 18;
    const color = opts.color || 'rgba(255,255,255,0.55)';

    let w, h, leaves;

    function resize() {
        w = canvas.width = canvas.offsetWidth;
        h = canvas.height = canvas.offsetHeight;
    }

    function makeLeaf() {
        return {
            x: Math.random() * w,
            y: Math.random() * h - h,
            size: 6 + Math.random() * 10,
            speedY: 0.3 + Math.random() * 0.6,
            speedX: Math.sin(Math.random() * Math.PI),
            angle: Math.random() * Math.PI * 2,
            spin: (Math.random() - 0.5) * 0.02,
        };
    }

    function drawLeaf(l) {
        ctx.save();
        ctx.translate(l.x, l.y);
        ctx.rotate(l.angle);
        ctx.fillStyle = color;
        ctx.beginPath();
        // simpleng "dahon" shape gamit ang 2 curves
        ctx.moveTo(0, -l.size);
        ctx.quadraticCurveTo(l.size * 0.7, 0, 0, l.size);
        ctx.quadraticCurveTo(-l.size * 0.7, 0, 0, -l.size);
        ctx.fill();
        ctx.restore();
    }

    function tick() {
        ctx.clearRect(0, 0, w, h);
        leaves.forEach(l => {
            l.y += l.speedY;
            l.x += Math.sin(l.y / 40) * 0.6;
            l.angle += l.spin;
            if (l.y > h + 20) {
                Object.assign(l, makeLeaf(), { y: -20 });
            }
            drawLeaf(l);
        });
        requestAnimationFrame(tick);
    }

    resize();
    leaves = Array.from({ length: count }, makeLeaf);
    window.addEventListener('resize', resize);
    tick();
}

/**
 * initTopnavScroll()
 * ---------------------------------------------------------------
 * Nagdadagdag ng subtle shadow sa .topnav pag nag-scroll na ang user,
 * para malaman niyang "lumutang" na siya sa taas ng content.
 */
function initTopnavScroll() {
    const nav = document.querySelector('.topnav');
    if (!nav) return;
    const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 8);
    document.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/**
 * initTiltCards(selector)
 * ---------------------------------------------------------------
 * Binibigyan ng subtle 3D tilt ang mga event-choice card habang
 * ginagalaw ng mouse ang cursor sa ibabaw nito. Nawawala ang tilt
 * pag umalis ang cursor. Ito lang ang "hover motion" natin — hindi
 * na tayo naglagay ng fade/slide sa bawat section.
 */
function initTiltCards(selector) {
    document.querySelectorAll(selector).forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const r = card.getBoundingClientRect();
            const px = (e.clientX - r.left) / r.width - 0.5;
            const py = (e.clientY - r.top) / r.height - 0.5;
            card.style.transform = `perspective(700px) rotateY(${px * 6}deg) rotateX(${-py * 6}deg) translateY(-4px)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
}

/**
 * validateForm(formEl)
 * ---------------------------------------------------------------
 * Simpleng client-side validation: nagdadagdag ng ".invalid" class
 * (nag-shashake, tignan sa style.css) sa mga required field na blangko.
 * Return: true kung ok lahat, false kung may kulang.
 */
function validateForm(formEl) {
    let ok = true;
    formEl.querySelectorAll('[required]').forEach(input => {
        const field = input.closest('.field');
        if (!input.value || !input.value.toString().trim()) {
            ok = false;
            if (field) {
                field.classList.add('invalid');
                setTimeout(() => field.classList.remove('invalid'), 350);
            }
        }
    });
    return ok;
}

document.addEventListener('DOMContentLoaded', initTopnavScroll);
