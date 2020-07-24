<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Posting</h1>
            <router-link :to="{ name: 'create' }" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Tambah</router-link>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Posting data</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Judul</th>
                      <th>Nama Kategori</th>
                      <th>Konten</th>
                      <th>Gambar</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(post, index) in posts" :key="post.id">
                      <td>{{ post.judul }}</td>
                      <td>{{ post.category.nama_kategori }}</td>
                      <td>{{ post.isi }}</td>
                      <td>
                        <img :src="'/images/'+post.gambar" style="width: 150px" />
                      </td>
                      <td>{{ post.status }}</td>
                      <td class="text-center">
                        <router-link
                          :to="{name: 'edit', params: { id: post.id }}"
                          class="btn btn-sm btn-primary"
                        ><i class="fa fa-edit"></i> Edit</router-link>
                        <button
                          @click.prevent="PostDelete(post.id, index)"
                          class="btn btn-sm btn-danger"
                        ><i class="fa fa-trash"></i> Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
      posts: []
    };
  },
  created() {
    let uri = `http://lara.test/api/posts`;
    this.axios.get(uri).then(response => {
        console.log(response);
      this.posts = response.data.data;
    });
  },
  methods: {
    PostDelete(id, index) {
      this.axios
        .delete(`http://lara.test/api/posts/${id}`)
        .then(response => {
          this.posts.splice(index, 1);
        })
        .catch(error => {
          alert("system error!");
        });
    }
  }
};
</script>
