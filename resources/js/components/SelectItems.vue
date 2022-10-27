<template>
  <div>
      <multiselect
          v-model="item"
          ref="multiselect"
          placeholder="Buscador de articulos"
          label="nombre"
          track-by="id"
          open-direction="bottom"
          :options="items"
          :option-height="300"
          :show-labels="false"
          :searchable="true"
          :loading="isLoading"
          :internal-search="false"
          :clear-on-select="true"
          :close-on-select="true"
          :allow-empty="false"
          :options-limit="20"
          :max-height="600"
          :show-no-results="false"
          :hide-selected="false"
          @search-change="asyncFind"
          @select="clear"
          selectLabel="Presione enter para selecionar"
          selectedLabel="Seleccionado"
          deselectLabel="Presione enter para remover"
      >



          <template slot="singleLabel" slot-scope="props">
              <div class='select-result-content clearfix' style="max-width: 100%">
                  <div class='select-result__avatar'>
                      <img :src='props.option.thumb' class='img-responsive' alt='Image'>
                  </div>
                  <div class='result-container text-uppercase'>

                      <div class='select-result__nombre' v-text="props.option.nombre"></div>

                      <div class='select-result__precio' v-show="!solicitud">
                          <i class='far fa-money-bill-alt'></i>
                          <span v-text="props.option.precio_compra"></span>
                      </div>
                      <div class='select-result__stock '>
                          <i class='fas fa-cubes'></i>
                          <span v-text="props.option.stock"></span>
                      </div>
                      <div class='select-result__ubicacion' v-show="!solicitud">
                          <i class='fas fa-archive'></i>
                          <span v-text="props.option.ubicacion"></span>
                      </div>
                      <div class='select-result__codigo'>
                          <i class='fas fa-barcode'></i>
                          <span v-text="props.option.codigo"></span>
                      </div>
                      <div class='select-result__contiene'>
                          <span v-html="props.option.descripcion"></span>
                      </div>
                  </div>
              </div>
          </template>

          <template slot="option" slot-scope="props">
              <div class='select-result-content clearfix' style="max-width: 100%">
                  <div class='select-result__avatar'>
                      <img :src='props.option.thumb' class='img-responsive' alt='Image'>
                  </div>
                  <div class='result-container text-uppercase'>

                      <div class='select-result__nombre' v-text="props.option.nombre"></div>

                      <div class='select-result__precio' v-show="!solicitud">
                          <i class='far fa-money-bill-alt'></i>
                          <span v-text="props.option.precio_compra"></span>
                      </div>
                      <div class='select-result__stock '>
                          <i class='fas fa-cubes'></i>
                          <span v-text="props.option.stock"></span>
                      </div>
                      <div class='select-result__ubicacion'>
                          <i class='fas fa-archive'></i>
                          <span v-text="props.option.ubicacion" v-show="!solicitud"></span>
                      </div>
                      <div class='select-result__codigo'>
                          <i class='fas fa-barcode'></i>
                          <span v-text="props.option.codigo"></span>
                      </div>
                      <div class='select-result__contiene'>
                          <span v-html="props.option.descripcion"></span>
                      </div>
                  </div>
              </div>
          </template>

          <span slot="noResult">Oops! No se encontraron elementos. Considere cambiar la consulta de búsqueda.</span>


          <template slot="noOptions">
              Ingrese código,nombre o descripción para la búsqueda
          </template>

      </multiselect>
  </div>
</template>

<script>

    import Multiselect from 'vue-multiselect'

    export default {
        name: 'select-items',
        components: {
            Multiselect
        },
        mounted(){
        },
        created() {
            this.item = this.value;
        },
        props:{
            value: {
                default: null,
                required: true
            },
            api: {
                type: String,
                required: true
            },
            solicitud: {
                type: Boolean,
                default:false
            }
        },
        data: () => ({
            items : [],
            isLoading: false,
            item: null
        }),
        computed: {
            titulo () {
                return 'hola';
            }
        },
        watch: {
            loading (val) {
                val || this.getDatos()
            },
            item (val) {
                if (!val){
                    this.items = [];
                }
                this.$emit('input', val);
            },
            value(val){
                logI('cambio valor');
                this.item = val;
            }
        },
        methods: {

            async asyncFind(query) {

                if (query!='' && query.length > 3){


                    this.isLoading = true;

                    try{

                        let data= { params: {search: query} };

                        const res = await axios.get(this.api,data);
                        this.items = res.data.data;

                        this.isLoading = false;

                    }catch (error) {

                        this.isLoading = false;
                        if (error.response){
                            logI(error.response.data)
                        }else {
                            logI(error)
                        }

                    }

                }

            },
            customLabel (option) {
                return `${option.nombre}`
            },
            clear(){
                this.items = [];
            }

        }
    }
</script>


<style scoped>

    @import "../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";
    .select-result-content { padding: 0px; }
    .select-result__avatar { float: left; width: 60px; margin-right: 5px; }
    .select-result__avatar img { width: 100%; height: auto; border-radius: 2px; }
    .result-container { margin-left: 65px; }
    .select-result__nombre { color: black; font-weight: bold; word-wrap: break-word; line-height: 1; font-size: 16px}
    .select-result__nombre { margin-bottom: 2px;}
    .select-result__precio,.select-result__stock, .select-result__ubicacion  { margin-right: 1em; }
    .select-result__precio, .select-result__ubicacion, .select-result__stock, .select-result__codigo {
        font-weight: bold; margin-bottom: 0px; margin-top: 0px; display: inline-block; color: #4078FA; font-size: 22px; padding: 0px;
    }
    .select-result__contiene {
        color: #777;
        inline-size: 100%;
        overflow-x: visible;
        line-height: 1;
        font-size: 11px
    }
    .multiselect__option--highlight .select-result__nombre,
    .multiselect__option--highlight .select-result__precio,
    .multiselect__option--highlight .select-result__stock,
    .multiselect__option--highlight .select-result__codigo,
    .multiselect__option--highlight .select-result__ubicacion { color: #F2FC2A; }
    .multiselect__option--highlight .select-result__contiene {
        color: #c6dcef;
    }
    .multiselect__option {
        width: 100%;
    }
</style>
