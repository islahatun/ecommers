<template>
    <v-container class="fill-height">
        <v-responsive class="fill-height">
            <v-breadcrumbs :items="items">
                <template v-slot:driver>
                    <v-icon icon="mdi-chevron-right"/>
                </template>
            </v-breadcrumbs>
            <v-divider></v-divider>
            <v-row>
              <v-col cols="8">
                <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items-length="totalItems"
                :items="serverItems"
                :loading="loading"
                item-value="name_product"
                @update;options="loadItems"/>
              </v-col>
              <v-col cols="4">
                <v-card title="Total Cart">
                  <v-card-item>
                    <div>
                      <v-row>
                        <v-col>Sub Total :</v-col>
                        <v-col>Rp 20.0000</v-col>
                      </v-row>
                      <v-divider></v-divider>
                      <v-row>
                        <v-col>Shipping :</v-col>
                      </v-row>
                      <v-row>
                        <v-col>
                          <v-radio-group>
                            <v-radio label="Free Shipping" value="1"></v-radio>
                            <v-radio label="Standard" value="2"></v-radio>
                            <v-radio label="Express" value="3"></v-radio>
                          </v-radio-group>
                        </v-col>
                        <v-col>

                        </v-col>
                      </v-row>
                    </div>
                  </v-card-item>
                </v-card>
              </v-col>
            </v-row>
        </v-responsive>
    </v-container>

</template>

<script>
    export default {
        data: () => ({
            items: [
                {
                    title: 'Dashboard',
                    disable: false,
                    href: 'breadcrumbs_dashboard'
                }, {
                    title: 'Link 1',
                    disable: false,
                    href: 'breadcrumbs_link_1'
                }, {
                    title: 'Link 2',
                    disable: true,
                    href: 'breadcrumbs_link_2'
                }
            ],
            itemsPerPage: 5,
            headers: [
                {
                    title: "Product",
                    align: "start",
                    sortable: false,
                    key: "name_product"
                }, {
                    title: "Price",
                    key: "price_product",
                    align: "end"
                }, {
                    title: "Quantity",
                    key: "quantity",
                    align: "end"
                }, {
                    title: "Total",
                    key: "total",
                    align: "end"
                }
            ],
            serverItems: [],
            loading: true,
            totalItems: 0
        }),

        methods: {
            loadItems({page, itemsPerPage, sortBy}) {
                this.loading = true
                FakeAPI
                    .fetch({page, itemsPerPage, sortBy})
                    .then(({items, total}) => {
                        this.serverItems = items
                        this.totalItems = total
                        this.loading = false
                    })
            }
        }
    }

    const products = [
        {
            name_product: "Lamp",
            price_product: 20000,
            quantity: 1,
            total: 20000

        }, {
            name_product: "table",
            price_product: 30000,
            quantity: 2,
            total: 60000

        }
    ]
    const FakeAPI = {
        async fetch({page, itemsPerPage, sortBy}) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const start = (page - 1) * itemsPerPage
                    const end = start + itemsPerPage
                    const items = products.slice()

                    if (sortBy.length) {
                        const sortKey = sortBy[0].key
                        const sortOrder = sortBy[0]
                            .order
                            items
                            .sort((a, b) => {
                                const aValue = a[sortKey]
                                const bValue = b[sortKey]
                                return sortOrder === "desc"
                                    ? bValue - aValue
                                    : aValue - bValue
                            })
                    }

                    const paginated = items.slice(start, end)

                    resolve({items: paginated, total: items.length})
                }, 500)
            })
        }
    }
</script>

<style></style>
