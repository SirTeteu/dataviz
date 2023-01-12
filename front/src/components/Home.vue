<template>
	<div class="container">
		<div class="align" v-if="((estados.length > 0) && refugiados.length > 0)">
			<v-slider
				class="slider-input"
				label="Ano"
				v-model="input.year"
				@change="selectData"
				:max="sliderRange.max"
				:min="sliderRange.min"
				thumb-color="#045a8d"
				thumb-label="always"
				vertical
			></v-slider>	

			<StainedGraph 
				:Yaxis="estados"
				:Xaxis="dataSelected"
				:maxTotal="maxTotal"
				group
			/>
		</div>

		<div class="center-loading" v-else>
			<v-progress-circular
				:size="50"
				color="#045a8d"
				indeterminate
			></v-progress-circular>
		</div>
	</div>
</template>

<script>
import StainedGraph from './StainedGraph';

import providerRefugiado from "../providers/RefugiadoProvider";
import providerEstado from "../providers/EstadoProvider";

export default {
  name: 'Home',

	components: {
		StainedGraph
	},

	data() {
		return {
			input: {
				year: 0
			},

			sliderRange: {
				max: 0,
				min: 0
			},

			dataSelected: [],

			estados: [],
			refugiados: [],

			descriptions: [
				{
					key: '2010',
					description: [
						'Terremoto e cólera no Haiti (Pessoas que procuraram abrigo no Brasil foram consideradas imigrantes, logo, seus dados não aparecem no banco de dados de refugiados)',
						'Instabilidade política por discordância no quesito de direitos trabalhistas em alguns países da América do Sul'
					]
				},
				{
					key: '2011',
					description: [
						'Crise de dívida na Europa',
						'Primavera Árabe',
						'Morte de Osama Bin Laden',
						'Fim da Guerra do Afeganistão'
					]	
				},
				{
					key: '2012',
					description: [
						'Crise com o  aumento do desemprego na Europa',
						'Reeleição de Barack Obama nos EUA',
						'Os combates cada vez mais violentos se estendem a Damasco e Aleppo na Síria',
						'Uma série de atentados reivindicada pelo grupo Estado Islâmico no Iraque (ISI) deixa quase 90 mortos e mais de 400 feridos'
					]
				},
				{
					key: '2013',
					description: [
						'Bombas na maratona de Boston matam 4 pessoas',
						'Auge da guerra na Síria por conta de ataques químicos',
						'Golpe de Estado no Egito com muitas mortes',
						'Com a intensificação no conflito na Síria, houve um considerável aumento na violência sectária no Líbano'
					]
				},
				{
					key: '2014',
					description: [
						'Início de protestos na Venezuela contra falta de segurança e crise econômica',
						'Sequestro de 276 alunas adolescentes de uma escola na Nigéria. O sequestro suscitou uma indignação internacional sem precedentes',
						'Segue o confronto na região da Síria e Iraque'
					]
				},
				{
					key: '2015',
					description: [
						'O Estado Islâmico amplia atuações, investindo em atentados em vários países e conseguindo tomar novos territórios',
						'A Rússia começa bombardeios contra o Estado Islâmico',
						'Estados Unidos realizam ataques no Afeganistão',
						'Ataques franceses na Síria após atentado em Paris ser reevidicado pelo Estado Islâmico'
					]
				},
				{
					key: '2016',
					description: [
						'A crise de refugiados bateu seu recorde de mortos – mais de 7 mil, de acordo com a Organização Internacional de Migrações (OMI)',
						'Síria entrou em seu quinto ano consecutivo de guerra',
						'Crise na Venezuela com declaração do estado de emergência pela escassez dos itens de serviço básico',
						'Continuação de ataques terroristas do Estado Islâmico'
					]
				},
				{
					key: '2017',
					description: [
						'Trump toma posse como presidente do EUA e assina um decreto anti-migratório',
						'Síria entrou em seu sexto ano consecutivo de guerra',
						'ONU denuncia limpeza étnica de minoria em Mianmar',
						'Continuam ataques terroristas ao redor do mundo'
					]
				},
				{
					key: '2018',
					description: [
						'Início de uma reforma constitucional em Cuba',
						'Eleições polêmicas na Venezuela em meio à pior crise moderna do país',
						'Trump remaneja tropas no Oriente Médio',
						'Continua guerra na Síria'
					]
				},
				{
					key: '2019',
					description: [
						'Retirada das tropas americanas do norte da Síria, provoca protestos internacionais',
						'Manifestações em Hong Kong',
						'Aumento de tensões entre EUA e Irã, que apresenta distúrbios internos',
						'Continua guerra na Síria',
						'Greves e manifestações na Venezuela, Equador, Bolívia e Colômbia'
					]
				},
				{
					key: '2020',
					description: [
						'Continuam tensões entre EUA e Irã',
						'Continua guerra na Síria',
						'Início da pandemia de coronavírus',
						'Novos ataques terroristas ao redor do mundo'
					]
				}
			]
		}
	},

	computed: {
		maxTotal() {
			let max = 0;

			for(let ano of this.refugiados) {
				if(ano.total > max) {
					max = ano.total;
				}
			}

			return max;
		}
	},

	mounted() {
		this.getEstados();
		this.getRefugiados();
	},

	methods: {
		getEstados() {
			providerEstado.get({
				success: data => {
					this.estados = data.data
				},

				error: (error) => {
					console.log(error);
				}
			});
		},

		getRefugiados() {
			providerRefugiado.get({
				success: data => {
					this.refugiados = data.data;

					this.sliderRange.max = this.refugiados[0].key * 1;
					this.sliderRange.min = this.refugiados[this.refugiados.length-1].key * 1;
					this.input.year = this.sliderRange.max;

					this.selectData();
				},

				error: (error) => {
					console.log(error);
				}
			});
		},

		selectData() {
			for(let data of this.refugiados) {
				if(data.key == this.input.year) {
					this.dataSelected = {
						total: data.total,
						items: data.items
					}
				}
			}

			for(let data of this.descriptions) {
				if(data.key == this.input.year) {
					this.dataSelected.description = data.description;
				}
			}
		}
	}
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container {
	max-width: 1180px;
    margin: 0 auto;
}

.align {
	display: flex;
}

.center-align {
	margin: 0 auto;
}

.center-loading {
	display: flex;
    justify-content: center;
    margin-top: 225px;
}

.slider-input {
	margin: 0 50px 0 0;
	max-width: 50px;
}
</style>
