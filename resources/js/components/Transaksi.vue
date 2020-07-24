<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transaksi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <!-- <a href="#">Dashboard</a> -->
                <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
              </li>
              <li class="breadcrumb-item active">Transaksi</li>
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
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaksi data</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Kode Transaksi</th>
                      <th>Tanggal</th>
                      <th>Total</th>
                      <th>Created at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(trans, index) in transaksi" :key="trans.id">
                      <td>{{ trans.kodetransaksi }}</td>
                      <td>{{ trans.tanggal }}</td>
                      <td>{{ trans.total }}</td>
                      <td>{{ trans.created_at }}</td>
                      <td class="text-center">
                        <button
                          @click="TransaksiDetail(trans.kodetransaksi, index)"
                          class="btn btn-sm btn-primary"
                        >
                          <i class="fa fa-eye"></i> Detail
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.card -->
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Detail Transaksi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Nama Produk</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ details.nama_produk }}</td>
                      <td>{{ details.qty }}</td>
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
      transaksi: [],
      details: ""
    };
  },
  created() {
    let uri = `http://lara.test/api/transaksi`;
    this.axios
      .get(uri)
      .then(response => {
        this.transaksi = response.data.data;
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    TransaksiDetail(id, index) {
      this.axios
        .get(`http://lara.test/api/transaksi/${id}`)
        .then(response => {
          console.log(response.data.data);
          this.details = response.data.data;
        })
        .catch(error => {
          alert("system error!");
        });
    }
  }
};
</script>
