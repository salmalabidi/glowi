@extends('layouts.app')

@section('content')
<style>
:root { --rose:#c8748a; --rose-deep:#a85070; --rose-pale:#f5e6ea; --gold:#c9a96e; --cream:#fdf6f0; --text:#3d2030; --text-light:#7a5c68; }

.checkout-page { max-width:1200px; margin:0 auto; padding:48px 48px 100px; }
.checkout-header { margin-bottom:32px; }
.checkout-title  { font-family:'Cormorant Garamond',serif; font-size:3rem; color:var(--text); font-weight:400; }
.checkout-subtitle { color:var(--text-light); margin-top:8px; }

.checkout-steps { display:flex; align-items:center; margin-bottom:36px; }
.cs-step { display:flex; align-items:center; gap:8px; font-size:.72rem; letter-spacing:.12em; text-transform:uppercase; color:var(--text-light); }
.cs-step.active { color:var(--rose-deep); font-weight:600; }
.cs-step.done   { color:#4fb06c; }
.cs-num { width:28px; height:28px; border-radius:50%; border:2px solid rgba(200,116,138,.25); display:flex; align-items:center; justify-content:center; font-size:.72rem; font-weight:700; background:#fff; }
.cs-step.active .cs-num { background:var(--rose); color:#fff; border-color:var(--rose); }
.cs-step.done   .cs-num { background:#4fb06c; color:#fff; border-color:#4fb06c; }
.cs-sep { flex:1; max-width:48px; height:1px; background:rgba(200,116,138,.2); margin:0 8px; }

.checkout-layout { display:grid; grid-template-columns:1.2fr 0.8fr; gap:32px; }
.checkout-card, .summary-card { background:#fff; border:1px solid rgba(200,116,138,.14); border-radius:18px; padding:28px; box-shadow:0 12px 30px rgba(36,18,25,.05); }
.section-title { font-family:'Cormorant Garamond',serif; font-size:1.8rem; margin-bottom:18px; color:var(--text); }
.user-info { display:grid; gap:14px; }
.info-row { padding:14px 16px; border-radius:10px; background:var(--rose-pale); color:var(--text); }
.info-label { display:block; font-size:.70rem; letter-spacing:.12em; text-transform:uppercase; color:var(--rose-deep); margin-bottom:6px; }

.order-list { display:flex; flex-direction:column; }
.order-item { display:grid; grid-template-columns:80px 1fr auto; gap:16px; align-items:center; padding:14px 0; border-bottom:1px solid rgba(200,116,138,.10); }
.order-item:last-child { border-bottom:none; }
.order-item img { width:80px; height:80px; object-fit:contain; background:var(--rose-pale); border-radius:10px; padding:8px; }
.item-name  { font-family:'Cormorant Garamond',serif; font-size:1.2rem; color:var(--text); }
.item-brand { color:var(--text-light); font-size:.82rem; margin-top:4px; }
.item-meta  { margin-top:8px; font-size:.80rem; color:var(--text-light); }
.item-price { color:var(--rose-deep); font-weight:600; font-size:1rem; }

.payment-section { margin-top:28px; }
.payment-header { display:flex; align-items:center; gap:10px; margin-bottom:20px; padding-bottom:14px; border-bottom:1px solid rgba(200,116,138,.12); }
.payment-header-icon { font-size:1.4rem; }
.payment-header-title { font-family:'Cormorant Garamond',serif; font-size:1.6rem; color:var(--text); }
.payment-badges { display:flex; gap:6px; margin-left:auto; }
.pay-badge { padding:4px 10px; border-radius:6px; font-size:.60rem; letter-spacing:.1em; text-transform:uppercase; font-weight:700; background:rgba(200,116,138,.09); color:var(--rose-deep); border:1px solid rgba(200,116,138,.15); }

.card-visual {
    background:linear-gradient(135deg,#3d2030 0%,#a85070 55%,#c9a96e 100%);
    border-radius:16px; padding:24px 24px 20px; margin-bottom:20px;
    position:relative; overflow:hidden; box-shadow:0 14px 32px rgba(36,18,25,.20); min-height:140px;
}
.card-visual::before { content:''; position:absolute; top:-30px; right:-40px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.06); }
.card-visual::after  { content:''; position:absolute; bottom:-60px; left:-20px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,.04); }
.cv-chip   { width:38px; height:28px; border-radius:5px; background:rgba(201,169,110,.55); margin-bottom:14px; }
.cv-number { font-size:1.15rem; letter-spacing:.18em; color:#fff; margin-bottom:14px; font-family:monospace; }
.cv-bottom { display:flex; justify-content:space-between; align-items:flex-end; }
.cv-label  { font-size:.56rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.12em; margin-bottom:3px; }
.cv-value  { font-size:.82rem; color:#fff; letter-spacing:.08em; }
.cv-brand  { font-size:1.4rem; opacity:.8; }

.form-group { margin-bottom:16px; }
.form-group label { display:block; font-size:.68rem; letter-spacing:.14em; text-transform:uppercase; color:var(--text-light); margin-bottom:6px; }
.form-input { width:100%; padding:13px 16px; border-radius:10px; border:1px solid rgba(200,116,138,.22); background:rgba(253,246,240,.70); color:var(--text); font-family:'Jost',sans-serif; font-size:.92rem; outline:none; transition:border-color .2s, box-shadow .2s, background .2s; letter-spacing:.06em; box-sizing:border-box; }
.form-input:focus { border-color:var(--rose); box-shadow:0 0 0 3px rgba(200,116,138,.10); background:#fff; }
.form-input::placeholder { color:rgba(122,92,104,.35); }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.secure-note { display:flex; align-items:center; gap:8px; margin-top:14px; font-size:.72rem; color:var(--text-light); padding:10px 14px; background:rgba(200,116,138,.04); border-radius:8px; border:1px solid rgba(200,116,138,.10); }

.summary-row { display:flex; justify-content:space-between; margin-bottom:14px; color:var(--text-light); }
.summary-total { display:flex; justify-content:space-between; margin-top:18px; padding-top:18px; border-top:1px solid rgba(200,116,138,.14); font-size:1.15rem; font-weight:600; color:var(--text); }

.confirm-btn { margin-top:22px; width:100%; background:var(--rose); color:#fff; border:none; padding:16px 18px; border-radius:10px; font-family:'Jost',sans-serif; letter-spacing:.1em; text-transform:uppercase; cursor:pointer; font-size:.82rem; transition:transform .25s, box-shadow .25s, background .25s; display:flex; align-items:center; justify-content:center; gap:8px; }
.confirm-btn:hover:not(:disabled) { transform:translateY(-2px); background:var(--rose-deep); box-shadow:0 14px 28px rgba(200,116,138,.22); }
.confirm-btn:disabled { background:#ccc; cursor:not-allowed; }

.note { margin-top:14px; font-size:.78rem; color:var(--text-light); line-height:1.7; }

@media(max-width:900px){
    .checkout-page { padding:32px 18px 80px; }
    .checkout-layout { grid-template-columns:1fr; }
    .order-item { grid-template-columns:1fr; }
    .form-row { grid-template-columns:1fr; }
}
</style>

<div class="checkout-page">
    <div class="checkout-header">
        <h1 class="checkout-title">Finaliser ma commande</h1>
        <p class="checkout-subtitle">Vérifiez vos informations et procédez au paiement.</p>
    </div>

    <div class="checkout-steps">
        <div class="cs-step done"><div class="cs-num">&#10003;</div><span>Panier</span></div>
        <div class="cs-sep"></div>
        <div class="cs-step active"><div class="cs-num">2</div><span>Paiement</span></div>
        <div class="cs-sep"></div>
        <div class="cs-step"><div class="cs-num">3</div><span>Confirmation</span></div>
    </div>

    <div class="checkout-layout">
        <div class="checkout-card">
            <h2 class="section-title">Informations client</h2>
            <div class="user-info">
                <div class="info-row"><span class="info-label">Nom</span>{{ auth()->user()->name }}</div>
                <div class="info-row"><span class="info-label">Email</span>{{ auth()->user()->email }}</div>
                <div class="info-row"><span class="info-label">Livraison</span>Offerte — délai estimé 2–4 jours ouvrés</div>
            </div>

            <h2 class="section-title" style="margin-top:28px;">Articles</h2>
            <div class="order-list">
                @foreach($cart as $item)
                <div class="order-item">
                    <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : 'https://via.placeholder.com/300/f5e6ea/c8748a?text=Glowi' }}" alt="{{ $item['name'] }}">
                    <div>
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-brand">{{ $item['brand'] }}</div>
                        <div class="item-meta">Qté : {{ $item['quantity'] }} · PU : {{ number_format($item['price'],2) }} TND</div>
                    </div>
                    <div class="item-price">{{ number_format($item['subtotal'],2) }} TND</div>
                </div>
                @endforeach
            </div>

            <div class="payment-section">
                <div class="payment-header">
                    <span class="payment-header-icon">&#128179;</span>
                    <div class="payment-header-title">Paiement sécurisé</div>
                    <div class="payment-badges">
                        <span class="pay-badge">Visa</span>
                        <span class="pay-badge">MC</span>
                        <span class="pay-badge">SSL</span>
                    </div>
                </div>

                <div class="card-visual">
                    <div class="cv-chip"></div>
                    <div class="cv-number" id="cvNumber">•••• •••• •••• ••••</div>
                    <div class="cv-bottom">
                        <div><div class="cv-label">Titulaire</div><div class="cv-value" id="cvName">NOM PRÉNOM</div></div>
                        <div><div class="cv-label">Expire</div><div class="cv-value" id="cvExp">MM/AA</div></div>
                        <div class="cv-brand" id="cvBrand">&#128179;</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Numéro de carte</label>
                    <input type="text" class="form-input" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" autocomplete="cc-number" inputmode="numeric">
                </div>
                <div class="form-group">
                    <label>Nom sur la carte</label>
                    <input type="text" class="form-input" id="cardName" placeholder="Ex : SALMA LABIDI" autocomplete="cc-name">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date d'expiration</label>
                        <input type="text" class="form-input" id="cardExp" placeholder="MM/AA" maxlength="5" autocomplete="cc-exp" inputmode="numeric">
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="password" class="form-input" id="cardCvv" placeholder="•••" maxlength="4" autocomplete="cc-csc" inputmode="numeric">
                    </div>
                </div>
                <div class="secure-note">&#128274; Vos informations de paiement sont chiffrées. Nous ne les stockons jamais.</div>
            </div>
        </div>

        <aside class="summary-card">
            <h2 class="section-title">Résumé</h2>
            <div class="summary-row"><span>Articles</span><span>{{ $cart->sum('quantity') }}</span></div>
            <div class="summary-row"><span>Livraison</span><span style="color:#4fb06c;">Offerte</span></div>
            <div class="summary-total"><span>Total</span><span>{{ number_format($total,2) }} TND</span></div>

            <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                @csrf
                <button type="button" class="confirm-btn" id="confirmBtn" onclick="submitOrder()" disabled>
                    <span id="confirmBtnText">&#128274; Confirmer la commande</span>
                </button>
            </form>

            <div id="paymentError" style="display:none;margin-top:10px;padding:10px 14px;border-radius:8px;background:rgba(212,98,98,.10);color:#a03030;font-size:.78rem;border:1px solid rgba(212,98,98,.2);"></div>

            <p class="note">Votre commande sera enregistrée et votre panier vidé automatiquement après confirmation.</p>

            <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(200,116,138,.10);">
                <div style="font-size:.68rem;color:var(--text-light);letter-spacing:.08em;text-transform:uppercase;margin-bottom:10px;">Paiement accepté</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span style="padding:5px 12px;border-radius:6px;border:1px solid rgba(200,116,138,.18);font-size:.70rem;color:var(--text-light);">&#128179; Visa</span>
                    <span style="padding:5px 12px;border-radius:6px;border:1px solid rgba(200,116,138,.18);font-size:.70rem;color:var(--text-light);">&#128179; Mastercard</span>
                    <span style="padding:5px 12px;border-radius:6px;border:1px solid rgba(200,116,138,.18);font-size:.70rem;color:var(--text-light);">&#128177; CIB</span>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
const cardNumberInput = document.getElementById('cardNumber');
const cardNameInput   = document.getElementById('cardName');
const cardExpInput    = document.getElementById('cardExp');
const cardCvvInput    = document.getElementById('cardCvv');
const confirmBtn      = document.getElementById('confirmBtn');
const paymentError    = document.getElementById('paymentError');

cardNumberInput.addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'').slice(0,16);
    this.value = v.replace(/(.{4})/g,'$1 ').trim();
    updateCardVisual(); validateForm();
});
cardExpInput.addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'').slice(0,4);
    if(v.length>=3) v = v.slice(0,2)+'/'+v.slice(2);
    this.value = v;
    updateCardVisual(); validateForm();
});
cardNameInput.addEventListener('input', function(){
    this.value = this.value.toUpperCase();
    updateCardVisual(); validateForm();
});
cardCvvInput.addEventListener('input', function(){
    this.value = this.value.replace(/\D/g,'').slice(0,4);
    validateForm();
});

function detectBrand(num){
    if(/^4/.test(num)) return '\uD83D\uDCB3 VISA';
    if(/^5[1-5]/.test(num)||/^2[2-7]/.test(num)) return '\uD83D\uDCB3 MC';
    return '\uD83D\uDCB3';
}
function luhn(num){
    let n=num.replace(/\s/g,'');
    if(n.length<13) return false;
    let sum=0,alt=false;
    for(let i=n.length-1;i>=0;i--){
        let d=parseInt(n[i]);
        if(alt){d*=2;if(d>9)d-=9;}
        sum+=d;alt=!alt;
    }
    return sum%10===0;
}
function updateCardVisual(){
    const raw  = cardNumberInput.value.replace(/\s/g,'');
    const name = cardNameInput.value||'NOM PRÉNOM';
    const exp  = cardExpInput.value||'MM/AA';
    let display = '•••• •••• •••• ••••';
    if(raw.length>0){
        const last4 = raw.slice(-Math.min(4,raw.length));
        const masked = '•'.repeat(Math.max(0,raw.length-4));
        display = (masked+last4).replace(/(.{4})/g,'$1 ').trim();
    }
    document.getElementById('cvNumber').textContent = display;
    document.getElementById('cvName').textContent   = name;
    document.getElementById('cvExp').textContent    = exp;
    document.getElementById('cvBrand').textContent  = detectBrand(raw);
}
function validateForm(){
    const num  = cardNumberInput.value.replace(/\s/g,'');
    const name = cardNameInput.value.trim();
    const exp  = cardExpInput.value;
    const cvv  = cardCvvInput.value;
    const ok = num.length===16 && luhn(num) && name.length>=3 && /^\d{2}\/\d{2}$/.test(exp) && cvv.length>=3;
    confirmBtn.disabled = !ok;
    cardNumberInput.style.borderColor = num.length>0 ? (num.length===16&&luhn(num)?'#4fb06c':'#e07070') : '';
    return ok;
}
function submitOrder(){
    paymentError.style.display='none';
    if(!validateForm()){
        paymentError.textContent='Veuillez vérifier vos informations de carte.';
        paymentError.style.display='block';
        return;
    }
    confirmBtn.disabled=true;
    document.getElementById('confirmBtnText').textContent='Traitement en cours…';
    setTimeout(()=>{ document.getElementById('checkoutForm').submit(); }, 1200);
}
</script>
@endsection
