<template>
    <transition name="fade">
        <div>
            
             <h5 class="pt-3">
                <template v-if="isMinAllowableSizeValues">
                    Количество листов: {{ listCount }}
                </template>
            </h5>
            <h5 class="pb-1">
                <template v-if="isMinAllowableSizeValues">
                    Количество изделий на листе: {{ layoutDimension }}
                </template>
            </h5>
            <div id="canvas_wrapper">
                <canvas id="canvas"/>
            </div>
            <b-button-group class="pt-2">
                <button
                    disabled
                    v-bind:class="{ 'btn-outline-success' : optimal }"
                    class="btn btn-outline-secondary d-flex align-items-center"
                >
                    <i v-if="optimal" class="material-icons-outlined pr-2">check</i>
                    <span class="pr-1">{{ optimal ? 'Оптимальная раскладка' : 'Не оптимальная раскладка' }}</span>
                </button>

                <b-button
                    :disabled="!canRotate"
                    v-on:click="rotate"
                    variant="success"
                    class="d-flex align-items-center"
                >
                    <i class="material-icons-outlined pr-2">rotate_right</i>
                    <span class="pr-1">{{ __('buttons.customer.order.rotate_layout') }}</span>
                </b-button>
            </b-button-group>
        </div>
    </transition>
</template>

<script>
import { LayoutCanvas } from "../../../lib/layoutCanvas";
import { cols, rows } from "../../../lib/countHelper";

export default {
    name: "LayoutFormComponent",

    props: ['bus', 'options'],

    data() {
        return {
            img: new Image(),
            form: {
                width: 0,
                height: 0,
                angle: 0,
                count: 0,
            },
            layout: null,

            layoutW: 0,
            layoutH: 0,
            fieldW: 0,
            fieldH: 0,
            bleed: 0,
            listCount: 0,
            isMinAllowableSizeValues: false,
        }
    },

    mounted() {
        this.initCanvas();
    },

    created() {
        this.bus.$on('previewLoaded', (data) => {
            this.loadImage(data.form.fileName);
        });

        this.bus.$on('layoutChanged', (data) => {
            Object.assign(this.form, data.form);
            this.isMinAllowableSizeValues = data.isMinAllowableSizeValues;

            if (this.layout.obj_type === 'rect') {
                this.layout.setRect(this.form.width, this.form.height);
            }
            this.countChanged(data);
        });

        this.bus.$on('fileChanged', () => {
            this.resetLayout();
        });

        this.bus.$on('countChanged', (data) => {
            this.countChanged(data);
        });

        this.bus.$on('materialsChanged', (data) => {
            this.initCanvas(data)
        });
    },

    computed: {
        canRotate() {
            return rows(this.form.width, this) * cols(this.form.height, this);
        },

        optimal() {
            if (this.form) {
                return (cols(this.form.width, this) * rows(this.form.height, this))
                    && cols(this.form.width, this) * rows(this.form.height, this)
                    >= cols(this.form.height, this) * rows(this.form.width, this);
            } else {
                return true;
            }
        },

        layoutDimension() {
            return this.isMinAllowableSizeValues ? cols(this.form.width, this) * rows(this.form.height, this) : 0;
        }
    },

    methods: {
        initCanvas(data) {
            if(data) {
                this.layoutW = parseFloat(data.form.layoutW);
                this.layoutH = parseFloat(data.form.layoutH);
                this.fieldW = parseFloat(data.form.fieldW);
                this.fieldH = parseFloat(data.form.fieldH);
                this.bleed = parseFloat(data.form.bleed);
            } 
            this.layout = new LayoutCanvas(
                this.layoutW,
                this.layoutH,
                this.fieldW,
                this.fieldH,
                this.bleed,
                'canvas_wrapper', 'canvas'
            );
            this.layout.init();
            this.layout.setObjType('rect');
        },

        countChanged(data) {
            this.listCount = data.form.count ? Math.ceil(data.form.count / this.layoutDimension) : 0
        },

        loadImage(fileName) {
            this.img.src = "/storage/" + fileName + ".tn.jpg";
            this.img.addEventListener('load', () => {
                this.layout.setObjType('img');
                this.layout.setImg(this.img, this.form.width, this.form.height);
                this.makeOptimalLayout();

                this.$emit('layoutInitialized', {
                    'canvas': this.layout
                });
            });
        },

        rotate() {
            if (this.form) {
                this.layout.rotate();
                this.form.angle = this.layout.canvas.angle ? this.layout.canvas.angle : 0;
                [this.form.width, this.form.height] = [this.form.height, this.form.width];
                this.$emit('layoutRotated', {
                    'angle': this.form.angle,
                    'canvas': this.layout
                });
            }
        },

        makeOptimalLayout() {
            this.$nextTick(function () {
                if (!this.optimal) {
                    this.rotate()
                }
            })
        },

        resetLayout() {
            this.layout.clear();
            this.isMinAllowableSizeValues = false;
            this.img = new Image();
            this.form = {
                width: 0,
                height: 0,
                angle: 0,
                count: 0,
            };
        }
    }
}
</script>
