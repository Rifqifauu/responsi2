<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Daftar Balapan</ion-title>
        <ion-buttons slot="end">
          <ion-button @click="showAddRaceModal">Tambah Balapan</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>
    
    <ion-content>
      <ion-list>
        <ion-item v-for="(race, index) in races" :key="race.id_balap">
          <ion-label>
            <h2>{{ race.nama_balapan }}</h2>
            <p>{{ race.deskripsi }}</p>
          </ion-label>
          <ion-buttons slot="end">
            <ion-button color="primary" @click="showEditRaceModal(race, index)">Edit</ion-button>
            <ion-button color="danger" @click="confirmDeleteRace(race.id_balap)">Hapus</ion-button>
          </ion-buttons>
        </ion-item>
      </ion-list>

      <!-- Modal Tambah/Edit Balapan -->
      <ion-modal 
        :is-open="isModalOpen" 
        @ionModalDidDismiss="closeModal"
      >
        <ion-header>
          <ion-toolbar>
            <ion-title>{{ isEditing ? 'Edit Balapan' : 'Tambah Balapan' }}</ion-title>
            <ion-buttons slot="end">
              <ion-button @click="closeModal">Tutup</ion-button>
            </ion-buttons>
          </ion-toolbar>
        </ion-header>
        
        <ion-content>
          <form @submit.prevent="saveRace">
            <ion-list>
              <ion-item>
                <ion-label position="floating">Nama Balapan</ion-label>
                <ion-input 
                  v-model="raceForm.nama_balapan" 
                  required 
                  clearInput
                ></ion-input>
              </ion-item>
              
              <ion-item>
                <ion-label position="floating">Deskripsi</ion-label>
                <ion-input 
                  v-model="raceForm.deskripsi" 
                  clearInput
                ></ion-input>
              </ion-item>
              
              <ion-button 
                type="submit" 
                expand="block" 
                class="ion-margin-top"
              >
                {{ isEditing ? 'Simpan Perubahan' : 'Tambah Balapan' }}
              </ion-button>
            </ion-list>
          </form>
        </ion-content>
      </ion-modal>
    </ion-content>
  </ion-page>
</template>

<script>
import axios from 'axios';

export default {
  name: 'RaceManagement',
  data() {
    return {
      races: [],
      isModalOpen: false,
      isEditing: false,
      raceForm: {
        nama_balapan: '',
        deskripsi: ''
      },
      editIndex: null,
      API_URL: 'http://127.0.0.1:8000/api/balapan'
    };
  },

  async created() {
    await this.fetchRaces();
  },

  methods: {
    async fetchRaces() {
      try {
        const response = await axios.get(this.API_URL);
        this.races = response.data;
      } catch (error) {
        this.handleError('Gagal mengambil data balapan', error);
      }
    },

    showAddRaceModal() {
      this.isEditing = false;
      this.raceForm = { nama_balapan: '', deskripsi: '' };
      this.isModalOpen = true;
    },

    showEditRaceModal(race, index) {
      this.isEditing = true;
      this.editIndex = index;
      this.raceForm = { ...race }; // Pastikan semua field terisi
      this.isModalOpen = true;
    },

    async saveRace() {
      try {
        const payload = {
          nama_balapan: this.raceForm.nama_balapan.trim(),
          deskripsi: this.raceForm.deskripsi.trim() || ''
        };

        if (this.isEditing) {
          const raceId = this.races[this.editIndex].id_balap;
          const response = await axios.put(`${this.API_URL}/${raceId}`, payload);
          this.$set(this.races, this.editIndex, { ...payload, id_balap: raceId });
          this.showToast('Balapan berhasil diperbarui');
        } else {
          const response = await axios.post(this.API_URL, payload);
          this.races.push(response.data);
          this.showToast('Balapan berhasil ditambahkan');
        }

        this.closeModal();
      } catch (error) {
        this.handleError('Gagal menyimpan balapan', error);
      }
    },
    async confirmDeleteRace(id_balap) {
      const confirmed = confirm('Apakah Anda yakin ingin menghapus balapan ini?');
      if (confirmed) {
        try {
          await axios.delete(`${this.API_URL}/${id_balap}`);
          this.races = this.races.filter(race => race.id_balap !== id_balap);
          this.showToast('Balapan berhasil dihapus');
        } catch (error) {
          this.handleError('Gagal menghapus balapan', error);
        }
      }
    },

    closeModal() {
      this.isModalOpen = false;
      this.raceForm = { nama_balapan: '', deskripsi: '' };
      this.editIndex = null;
    },

    handleError(message, error) {
      console.error(message, error);
      this.showToast(message);
    },

    showToast(message) {
      alert(message);
    }
  }
}
</script>

<style scoped>
ion-content {
  --background: #f4f5f8;
}

ion-item {
  --background: white;
  margin-bottom: 10px;
  border-radius: 8px;
}

ion-button {
  margin: 10px;
}
</style>