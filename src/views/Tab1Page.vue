<template>
  <ion-header>
    <ion-toolbar>
      <ion-title>Daftar Balapan</ion-title>
    </ion-toolbar>
  </ion-header>

  <ion-content>
    <ion-list>
      <ion-item v-for="balapan in balapanList" :key="balapan.id_balap">
        <ion-label>
          <h2>{{ balapan.nama_balapan }}</h2>
          <p>{{ balapan.deskripsi }}</p>
        </ion-label>
        <ion-button @click="openEditModal(balapan)">Edit</ion-button>
        <ion-button color="danger" @click="deleteBalapan(balapan.id_balap)">Hapus</ion-button>
      </ion-item>
    </ion-list>
    <ion-button expand="full" @click="addBalapan">Tambah Balapan</ion-button>

    <ion-modal :is-open="isEditModalOpen" @did-close="closeEditModal">
      <template #default>
        <ion-header>
          <ion-toolbar>
            <ion-title>Edit Balapan</ion-title>
            <ion-buttons slot="end">
              <ion-button @click="closeEditModal">Tutup</ion-button>
            </ion-buttons>
          </ion-toolbar>
        </ion-header>
        <ion-content>
          <ion-item>
            <ion-label position="floating">Nama Balapan</ion-label>
            <ion-input v-model="editBalapanData.nama_balapan"></ion-input>
          </ion-item>
          <ion-item>
            <ion-label position="floating">Deskripsi</ion-label>
            <ion-input v-model="editBalapanData.deskripsi"></ion-input>
          </ion-item>
          <ion-button expand="full" @click="updateBalapan">Simpan</ion-button>
        </ion-content>
      </template>
    </ion-modal>
  </ion-content>
</template>

<script>
import axios from 'axios';
import { IonModal, IonHeader, IonToolbar, IonTitle, IonContent, IonList, IonItem, IonLabel, IonButton, IonInput } from '@ionic/vue';

export default {
  components: {
    IonModal,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonList,
    IonItem,
    IonLabel,
    IonButton,
    IonInput,
  },
  data() {
    return {
      balapanList: [],
      isEditModalOpen: false,
      editBalapanData: {
        id_balap: null,
        nama_balapan: '',
        deskripsi: '',
      },
    };
  },
  methods: {
    async fetchBalapan() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/balapan');
        this.balapanList = response.data;
      } catch (error) {
        console.error('Error fetching balapan:', error);
      }
    },
    async deleteBalapan(id) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/balapan/${id}`);
        this.fetchBalapan(); // Refresh the list after deletion
      } catch (error) {
        console.error('Error deleting balapan:', error);
      }
    },
    openEditModal(balapan) {
  console.log('Edit button clicked', balapan); // Tambahkan ini untuk debug
  this.editBalapanData = { ...balapan }; // Salin data balapan yang akan diedit
  this.isEditModalOpen = true; // Buka modal
  console.log(this.editBalapanData)
},
    closeEditModal() {
      this.isEditModalOpen = false; // Tutup modal
    },
    async updateBalapan() {
      try {
        await axios.put(`http://127.0.0.1:8000/api/balapan/${this.editBalapanData.id_balap}`, this.editBalapanData);
        this.fetchBalapan(); // Refresh daftar balapan
        this.closeEditModal();
      } catch (error) {
        console.error('Error updating balapan:', error);
      }
    },
    addBalapan() {
      // Implement your add logic here
      console.log('Add new balapan');
    },
  },
  mounted() {
    this.fetchBalapan();
  },
};
</script>

<style scoped>
/* Add any styles you want here */
</style>