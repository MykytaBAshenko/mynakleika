function cols(t, layout) {
    return Math.floor((layout.layoutW - layout.fieldW * 2 + layout.bleed * 2) / (t + layout.bleed * 2));
}

function rows(t, layout) {
    return Math.floor((layout.layoutH - layout.fieldH * 2 + layout.bleed * 2) / (t + layout.bleed * 2));
}

export { cols, rows }
