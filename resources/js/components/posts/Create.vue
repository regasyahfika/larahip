<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Posting</h1><br>
            <div v-if="success != ''">
                <router-link :to="{ name: 'posts' }" class="alert alert-success">{{success}}, Lihat data</router-link>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <!-- <a href="#">Dashboard</a> -->
                <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
              </li>
              <li class="breadcrumb-item active">Post</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Posting data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" @submit.prevent="PostStore">
                <div class="card-body">
                  <div class="form-group">
                    <label>Kategori</label>
                    <select v-model="formFields.id_kategori" name="id_kategori" class="form-control">
                      <option value selected disabled>Select Kategori</option>
                      <option
                        v-for="category in kategori"
                        :key="category.id"
                        :value="category.id"
                      >{{ category.nama_kategori }}</option>
                    </select>
                    <div v-if="validation.id_kategori">
                      <div
                        class="alert alert-danger mt-1"
                        role="alert"
                      >{{ validation.id_kategori[0] }}</div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Judul</label>
                    <input
                      type="text" name="judul"
                      class="form-control"
                      v-model="formFields.judul"
                      placeholder="Masukkan Judul"
                    />
                    <div v-if="validation.judul">
                      <div class="alert alert-danger mt-1" role="alert">{{ validation.judul[0] }}</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Konten</label>
                    <textarea
                      class="form-control" name="isi"
                      v-model="formFields.isi"
                      rows="5"
                      placeholder="Masukkan isi Konten"
                    ></textarea>
                    <div v-if="validation.isi">
                      <div class="alert alert-danger mt-1" role="alert">{{ validation.isi[0] }}</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Gambar</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="gambar" @change="onFileChange" class="custom-file-input" id="exampleInputFile" />
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div v-if="validation.gambar">
                      <div class="alert alert-danger mt-1" role="alert">{{ validation.gambar[0] }}</div>
                    </div>
                  <div class="form-group" v-if="success == '' && formFields.judul == '' || formFields.judul !== ''">
                      <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview" />
                  </div>
                  <div class="form-check">
                    <input type="checkbox" name="status" class="form-check-input" id="exampleCheck1" v-model="formFields.status"
                      true-value="true"
                      false-value="false" />
                    <label class="form-check-label" for="exampleCheck1">Status</label>
                  </div>
                  <div v-if="validation.status">
                      <div class="alert alert-danger mt-1" role="alert">{{ validation.status[0] }}</div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      post: {},
      validation: [],
      kategori: [],
      success: "",
      imagePreview: '',
      showPreview: false,
      formFields: {
        judul: '',
        isi: '',
        status: '',
        id_kategori: '',
        gambar: ''
      }
    };
  },
  created() {
    let uri = `http://lara.test/api/kategori`;
    this.axios.get(uri).then(response => {
      this.kategori = response.data.data;
    });
  },
  methods: {
    onFileChange(event) {
      this.formFields.gambar = event.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function() {
          this.showPreview = true;
          this.imagePreview = reader.result;
        }.bind(this),
        false
      );
      if (this.formFields.gambar) {
        if (/\.(jpe?g|png|gif)$/i.test(this.formFields.gambar.name)) {
          reader.readAsDataURL(this.formFields.gambar);
        }
      }
    },
    PostStore(e) {
      let currentObj = this;
      let uri = "http://lara.test/api/posts/store";
      const formData = new FormData();
      formData.append("gambar", this.formFields.gambar);
      formData.append("judul", this.formFields.judul);
      formData.append("isi", this.formFields.isi);
      formData.append("status", this.formFields.status);
      formData.append("id_kategori", this.formFields.id_kategori);

      this.axios
        .post(uri, formData)
        .then(response => {
          currentObj.success = response.data.message;
          this.resetForm();
          // this.$router.push({
          //   name: "posts"
          // });
        })
        .catch(error => {
          this.validation = error.response.data.data;
        });
    },
    resetForm() {
        var self = this;
        Object.keys(this.formFields).forEach(function(key,index) {
          self.formFields[key] = '';
        });
      }
  }
};
</script>
