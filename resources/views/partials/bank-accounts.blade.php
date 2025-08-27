<div class="bank-info">
    <div class="fw-bold mb-2">Pembayaran dapat dilakukan melalui:</div>
    <div class="bank-list">
        <div class="bank-item">
            <span class="bank-name">Bank BRI</span>
            <span class="bank-account">7620-01-000033-56-5</span>
            <span class="account-name">a.n Yayasan Satriabudi Dharma Medika</span>
        </div>
        <div class="bank-item">
            <span class="bank-name">Bank BCA</span>
            <span class="bank-account">497-4237719</span>
            <span class="account-name">a.n Yayasan Satriabudi Dharma Medika</span>
        </div>
        <div class="bank-item">
            <span class="bank-name">Panin Bank</span>
            <span class="bank-account">1005008515</span>
            <span class="account-name">a.n Yayasan Satriabudi Dharma Medika</span>
        </div>
    </div>
</div>

<style>
.bank-info {
    line-height: 1.6;
}

.bank-list {
    margin-left: 1rem;
}

.bank-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.bank-name {
    font-weight: 600;
    min-width: 80px;
}

.bank-account {
    font-family: 'Courier New', monospace;
    font-weight: 500;
    color: #0066cc;
}

.account-name {
    color: #666;
}

@media print {
    .bank-item {
        font-size: 9px;
    }
    
    .bank-name {
        font-weight: 600;
    }
    
    .bank-account {
        color: black;
    }
}
</style>