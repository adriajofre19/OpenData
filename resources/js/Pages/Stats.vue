<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';
import Navbar from '@/Components/Navbar.vue';
import Background from '@/Components/Background.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { defineProps, onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import axios from 'axios';
import { ref } from 'vue';
import Chart from 'primevue/chart';

const props = defineProps(['result1', 'result2']);

onMounted(() => {
    chartData1.value = setChartData1(props.result1);
    chartOptions1.value = setChartOptions1();

    chartData2.value = setChartData2(props.result2);
    chartOptions2.value = setChartOptions2();
});

const chartData1 = ref();
const chartOptions1 = ref(null);
const chartData2 = ref();
const chartOptions2 = ref(null);

const setChartData1 = (data) => {
    if (!Array.isArray(data.original)) {
        console.error("Data.original is not an array:", data.original);
        return;
    }
    
    const categories = data.original.map(item => item.category_name);
    const percentages = data.original.map(item => parseFloat(item.percentage));
    
    // Array de colores para cada categoría
    const colors = [
        '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
    ];

    // Asegurarse de tener suficientes colores para todas las categorías
    const backgroundColors = colors.slice(0, categories.length);
    
    return {
        labels: categories,
        datasets: [
            {
                data: percentages,
                backgroundColor: backgroundColors,
            }
        ]
    };
};
const setChartData2 = (data) => {
    if (!Array.isArray(data.original)) {
        console.error("Data.original is not an array:", data.original);
        return;
    }
    
    const plans = data.original.map(item => item.plan_name); // Extraer nombres de planes
    const percentages = data.original.map(item => parseFloat(item.percentage));
    
    // Array de colores para cada categoría
    const colors = [
        '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A', 
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC', 
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3', 
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'
    ];

    // Asegurarse de tener suficientes colores para todas las categorías
    const backgroundColors = colors.slice(0, plans.length);
    
    return {
        labels: plans,
        datasets: [
            {
                data: percentages,
                backgroundColor: backgroundColors,
            }
        ]
    };
};

const setChartOptions1 = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');

    return {
        plugins: {
            legend: {
                position: 'left',
                labels: {
                    cutout: '60%',
                    color: textColor,
                    padding: 20,
                    // Ajustar el máximo de elementos de la leyenda para mostrar todas las categorías
                    maxItems: Infinity
                }
            }
        }
    };
};
const setChartOptions2 = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');

    return {
        plugins: {
            legend: {
                position: 'left',
                labels: {
                    cutout: '60%',
                    color: textColor,
                    padding: 20,
                    // Ajustar el máximo de elementos de la leyenda para mostrar todas las categorías
                    maxItems: Infinity
                }
            }
        }
    };
};
</script>

<template>
    <Navbar></Navbar>
<div class="sm:ml-40">
    <div class="relative overflow-x-auto">
            <div class="chart-container mt-4 mr-4 ml-4"> <!-- Ajusta el margen izquierdo (ml-2) para corregir la alineación -->
                <div class="chart-title">Percentatge de les categories</div>
                <div class="card flex justify-content-center align-items-center shadow-md sm:rounded-lg">
                    <Chart type="doughnut" :data="chartData1" :options="chartOptions1" class="w-full"/>
                </div>
            </div>
            <!-- Segundo gráfico -->
            <div class="chart-container mt-4 mr-4 ml-4"> <!-- Ajusta el margen izquierdo (ml-2) para corregir la alineación -->
                <div class="chart-title">Percentatge dels plans</div>
                <div class="card flex justify-content-center align-items-center shadow-md sm:rounded-lg">
                    <Chart type="doughnut" :data="chartData2" :options="chartOptions2" class="w-full2"/>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.chart-container {
    margin-bottom: 20px; /* Espacio entre los gráficos */
}

.chart-title {
    font-size: 1.5rem;
    text-align: center;
    background-color: rgb(30 41 59); /* Fondo negro para el título */
    color: #ffffff; /* Texto blanco para el título */
    padding: 10px; /* Espacio interno */
    border-top-left-radius: 10px; /* Redondear esquina superior izquierda */
    border-top-right-radius: 10px; /* Redondear esquina superior derecha */
}

.card {
    background-color: #ffffff; /* Fondo blanco */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
    padding: 16px; /* Espacio interno ajustado */
}

.w-full {
    height: 600px;
    width: 600px;
}

.w-full2 {
    height: 770px;
    width: 770px;
}

/* Estilos para centrar los gráficos */
.flex {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>




