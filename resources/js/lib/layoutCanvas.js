import { cols, rows } from "./countHelper";

export class LayoutCanvas {

    constructor (width, height, fieldW, fieldH, bleed, wrapper, canvas) {
        this.layoutW = width;
        this.layoutH = height;
        this.vw = width;
        this.vh = height;
        this.fieldW = fieldW;
        this.fieldH = fieldH;
        this.bleed = bleed;
        this.wrapper = wrapper;
        this.canvas = canvas;
        // window.addEventListener('resize', () => this.resize());
    }

    init () {
        this.canvas_wrapper = document.getElementById(this.wrapper);
        this.canvas = document.getElementById(this.canvas);
        this.ctx = this.canvas.getContext('2d');
        this.obj_type = 'rect';
        this.canvas.angle = 0;

        // init number of cols and rows
        this.cols = 1;
        this.rows = 1;

        // init img
        this.cimg = {};
        this.cimg.vw = 0;
        this.cimg.vh = 0;
        this.cimg.xsp = 0;
        this.cimg.ysp = 0;

        // init rect
        this.rect = {};
        this.rect.width = 0;
        this.rect.height = 0;
        this.rect.xsp = 0;
        this.rect.ysp = 0;

        // set canvas width and height
        this.canvas.width = this.canvas_wrapper.clientWidth - 2;
        this.canvas.height = this.layoutH / this.layoutW * this.canvas.width;

        // scale multiplier
        this.k = this.canvas.width / this.layoutW;
    }

    setObjType (type) {
        this.obj_type = type;
    }

    setRect (width, height) {
        this.clear();
        this.rect.width = width;
        this.rect.height = height;
        this.setCols();
        this.setRows();
        this.setStartPoint();
        this.ctx.lineWidth = 1;
        this.ctx.strokeStyle = '#777777';
        this.drawRect();
    }

    setImg (img, width, height) {
        this.clear();
        this.cimg = img;
        this.cimg.width = width;
        this.cimg.height = height;
        this.cimg.vw = width;
        this.cimg.vh = height;
        this.setCols();
        this.setRows();
        this.setStartPoint();
        this.drawImg();
    }

    setCols() {
        // number of mock by width
        // this.cols = cols(this.rect.width, this);
        this.obj_type === 'rect'
            ? this.cols = Math.floor((this.layoutW - this.fieldW * 2 + this.bleed * 2) / (this.rect.width + this.bleed * 2))
            : this.cols = Math.floor((this.layoutW - this.fieldW * 2 + this.bleed * 2) / (this.cimg.vw + this.bleed * 2));
    }

    setRows() {
        // number of mock by height
        // this.rows = rows(this.rect.height, this);
        this.obj_type === 'rect'
            ? this.rows = Math.floor((this.layoutH - this.fieldH * 2 + this.bleed * 2) / (this.rect.height + this.bleed * 2))
            : this.rows = Math.floor((this.layoutH - this.fieldH * 2 + this.bleed * 2) / (this.cimg.vh + this.bleed * 2));
    }

    setStartPoint() {
        if (this.obj_type === 'rect') {
            this.rect.xsp = (this.layoutW - this.cols * (this.rect.width + this.bleed * 2)) / 2;
            this.rect.ysp = (this.layoutH - this.rows * (this.rect.height + this.bleed * 2)) / 2;
        }
        else {
            this.cimg.xsp = (this.layoutW - this.cols * (this.cimg.width + this.bleed)) / 2;
            this.cimg.ysp = (this.layoutH - this.rows * (this.cimg.height + this.bleed)) / 2;
        }
    }

    drawRect () {
        for (let x = 0; x < this.cols; x++) {
            for (let y = 0; y < this.rows; y++) {
                this.ctx.strokeRect(
                    (this.rect.xsp + (this.rect.width + this.bleed * 2) * x + 3) * this.k,
                    (this.rect.ysp + (this.rect.height + this.bleed * 2) * y + 3) * this.k,
                    (this.rect.width) * this.k,
                    (this.rect.height) * this.k
                );
            }
        }
    }

    drawImg () {
        for (let x = 0; x < this.cols; x++) {
            for (let y = 0; y < this.rows; y++) {
                this.ctx.drawImage(this.cimg,
                    (this.cimg.xsp + (this.cimg.width  + this.bleed) * x) * this.k,
                    (this.cimg.ysp + (this.cimg.height  + this.bleed) * y) * this.k,
                    this.cimg.width * this.k,
                    this.cimg.height * this.k
                );
            }
        }
    }

    draw() {
        this.obj_type === 'rect' ? this.drawRect() : this.drawImg();
    }

    rotateRect () {
        this.clear();
        [this.rect.width, this.rect.height] = [this.rect.height, this.rect.width];
        this.setCols();
        this.setRows();
        this.setStartPoint();
        this.drawRect();
    }

    rotateImg () {
        this.ctx.clearRect(-1000, -1000, 3000, 3000);
        this.ctx.translate(this.layoutW / 2 * this.k, this.layoutH / 2 * this.k);
        this.canvas.angle < 270 ? this.canvas.angle += 90 : this.canvas.angle = 0;
        this.ctx.rotate((Math.PI / 180) * (-90));
        this.ctx.translate(-this.layoutW / 2 * this.k, -this.layoutH / 2 * this.k);

        [this.cimg.vw, this.cimg.vh] = [this.cimg.vh, this.cimg.vw];
        this.setCols();
        this.setRows();

        if (this.canvas.angle === 90 || this.canvas.angle === 270) {
            [this.cols, this.rows] = [this.rows, this.cols];
        }
        this.setStartPoint();
        this.drawImg();
    }

    rotate() {
        this.obj_type === 'rect' ? this.rotateRect() : this.rotateImg();
    }

    flush_canvas_rotate() {
        while (this.canvas.angle !== 0) {
            this.ctx.translate(this.layoutW / 2 * this.k, this.layoutH / 2 * this.k);
            this.canvas.angle < 270 ? this.canvas.angle += 90 : this.canvas.angle = 0;
            this.ctx.rotate((Math.PI / 180) * 90);
            this.ctx.translate(-this.layoutW / 2 * this.k, -this.layoutH / 2 * this.k);
        }
    }

    resize () {
        this.canvas.width = this.canvas_wrapper.clientWidth - 2;
        this.canvas.height = this.layoutH / this.layoutW * this.canvas.width;
        this.k = this.canvas.width / this.layoutW;
        this.draw();
    }

    clear() {
        this.ctx.clearRect(0, 0, this.canvas.clientWidth, this.canvas.clientHeight);
        this.flush_canvas_rotate();
        //this.ctx.strokeRect(0, 0, this.layoutW * this.k, this.layoutH * this.k);
    }

    toDataUrl() {
        return this.canvas.toDataURL();
    }
}
