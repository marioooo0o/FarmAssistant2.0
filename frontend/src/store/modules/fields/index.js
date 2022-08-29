import mutations from './mutations.js';
import actions from './actions.js';
import getters from './getters.js';

export default{
    namespaced: true,
    state(){
        return {
            allCrops: [
                {
                    id: 1,
                    name: 'Tomato',
                    src: '/src/assets/crops/tomato.png',
                },
                {
                    id: 2,
                    name: 'Ogorek',
                    src: '/src/assets/crops/tomato.png',
                },
                {
                    id: 3,
                    name: 'Pszenica',
                    src: '/src/assets/crops/tomato.png',
                },
                {
                    id: 4,
                    name: 'Trzcina',
                    src: '/src/assets/crops/tomato.png',
                },
            ],
            allParcels: [
                {
                    id: 1,
                    parcel_number: "12345",
                    parcel_area: 12,
                    soil_Ph: null,
                    created_at: "2022-08-03T05:00:20.000000Z",
                    updated_at: "2022-08-26T09:46:36.000000Z",
                    fields: [
                        {
                            id: 11,
                            farm_id: 6,
                            crop_id: 5,
                            field_name: "Najnowsze pole",
                            field_area: 16.7,
                            created_at: "2022-08-26T09:39:47.000000Z",
                            updated_at: "2022-08-26T09:48:37.000000Z",
                            pivot: {
                                cadastral_parcel_id: 1,
                                field_id: 11,
                                area: 12,
                                created_at: "2022-08-26T09:46:35.000000Z",
                                updated_at: "2022-08-26T09:46:35.000000Z"
                            }
                        }
                    ]
                },
                {
                    id: 2,
                    parcel_number: "123456",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T05:00:21.000000Z",
                    updated_at: "2022-08-03T05:04:47.000000Z",
                    fields: []
                },
                {
                    id: 3,
                    parcel_number: "25647",
                    parcel_area: 10,
                    soil_Ph: null,
                    created_at: "2022-08-03T05:41:53.000000Z",
                    updated_at: "2022-08-26T09:49:15.000000Z",
                    fields: [
                        {
                            id: 11,
                            farm_id: 6,
                            crop_id: 5,
                            field_name: "Najnowsze pole",
                            field_area: 16.7,
                            created_at: "2022-08-26T09:39:47.000000Z",
                            updated_at: "2022-08-26T09:48:37.000000Z",
                            pivot: {
                                cadastral_parcel_id: 3,
                                field_id: 11,
                                area: 4.7,
                                created_at: "2022-08-26T09:48:36.000000Z",
                                updated_at: "2022-08-26T09:48:36.000000Z"
                            }
                        },
                        {
                            id: 12,
                            farm_id: 6,
                            crop_id: 5,
                            field_name: "Najnowsze pole2",
                            field_area: 6.5,
                            created_at: "2022-08-26T09:40:05.000000Z",
                            updated_at: "2022-08-26T09:50:23.000000Z",
                            pivot: {
                                cadastral_parcel_id: 3,
                                field_id: 12,
                                area: 5.3,
                                created_at: "2022-08-26T09:49:14.000000Z",
                                updated_at: "2022-08-26T09:49:14.000000Z"
                            }
                        }
                    ]
                },
                {
                    id: 4,
                    parcel_number: "5697412",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T05:41:54.000000Z",
                    updated_at: "2022-08-03T05:41:54.000000Z",
                    fields: []
                },
                {
                    id: 5,
                    parcel_number: "2564785",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T08:56:47.000000Z",
                    updated_at: "2022-08-03T09:04:00.000000Z",
                    fields: []
                },
                {
                    id: 6,
                    parcel_number: "569741214",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T08:56:47.000000Z",
                    updated_at: "2022-08-03T09:04:00.000000Z",
                    fields: []
                },
                {
                    id: 7,
                    parcel_number: "2564777",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T09:04:00.000000Z",
                    updated_at: "2022-08-03T13:06:38.000000Z",
                    fields: []
                },
                {
                    id: 8,
                    parcel_number: "569741218",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T09:04:01.000000Z",
                    updated_at: "2022-08-03T13:06:38.000000Z",
                    fields: []
                },
                {
                    id: 9,
                    parcel_number: "4548415",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T12:21:21.000000Z",
                    updated_at: "2022-08-03T12:21:21.000000Z",
                    fields: []
                },
                {
                    id: 10,
                    parcel_number: "5697411",
                    parcel_area: 0,
                    soil_Ph: null,
                    created_at: "2022-08-03T12:21:21.000000Z",
                    updated_at: "2022-08-03T12:21:21.000000Z",
                    fields: []
                },
                {
                    id: 11,
                    parcel_number: "458",
                    parcel_area: 1.2,
                    soil_Ph: null,
                    created_at: "2022-08-26T09:50:21.000000Z",
                    updated_at: "2022-08-26T09:50:22.000000Z",
                    fields: [
                        {
                            id: 12,
                            farm_id: 6,
                            crop_id: 5,
                            field_name: "Najnowsze pole2",
                            field_area: 6.5,
                            created_at: "2022-08-26T09:40:05.000000Z",
                            updated_at: "2022-08-26T09:50:23.000000Z",
                            pivot: {
                                cadastral_parcel_id: 11,
                                field_id: 12,
                                area: 1.2,
                                created_at: "2022-08-26T09:50:22.000000Z",
                                updated_at: "2022-08-26T09:50:22.000000Z"
                            }
                        }
                    ]
                }
            ],
            userFields: [
            {
                id: 11,
                farm_id: 6,
                field_name: "Najnowsze pole",
                field_area: 16.7,
                cadastral_parcels: [
                    {
                        id: 1,
                        parcel_number: "12345",
                        parcel_area: 12,
                        soil_Ph: null,
                        created_at: "2022-08-03T05:00:20.000000Z",
                        updated_at: "2022-08-26T09:46:36.000000Z",
                        pivot: {
                            field_id: 11,
                            cadastral_parcel_id: 1,
                            area: 12,
                            created_at: "2022-08-26T09:46:35.000000Z",
                            updated_at: "2022-08-26T09:46:35.000000Z"
                        }
                    },
                    {
                        id: 3,
                        parcel_number: "25647",
                        parcel_area: 10,
                        soil_Ph: null,
                        created_at: "2022-08-03T05:41:53.000000Z",
                        updated_at: "2022-08-26T09:49:15.000000Z",
                        pivot: {
                            field_id: 11,
                            cadastral_parcel_id: 3,
                            area: 4.7,
                            created_at: "2022-08-26T09:48:36.000000Z",
                            updated_at: "2022-08-26T09:48:36.000000Z"
                        }
                    }
                ],
                crop: {
                    id: 5,
                    name: "Clare Hansen",
                    src: "/src/assets/crops/tomato.png",
                    created_at: "2022-08-02T19:35:24.000000Z",
                    updated_at: "2022-08-02T19:35:24.000000Z"
                },
                created_at: "2022-08-26T09:39:47.000000Z",
                updated_at: "2022-08-26T09:48:37.000000Z"
            },
            {
                id: 12,
                farm_id: 6,
                field_name: "Najnowsze pole2",
                field_area: 6.5,
                cadastral_parcels: [
                    {
                        id: 3,
                        parcel_number: "25647",
                        parcel_area: 10,
                        soil_Ph: null,
                        created_at: "2022-08-03T05:41:53.000000Z",
                        updated_at: "2022-08-26T09:49:15.000000Z",
                        pivot: {
                            field_id: 12,
                            cadastral_parcel_id: 3,
                            area: 5.3,
                            created_at: "2022-08-26T09:49:14.000000Z",
                            updated_at: "2022-08-26T09:49:14.000000Z"
                        }
                    },
                    {
                        id: 11,
                        parcel_number: "458",
                        parcel_area: 1.2,
                        soil_Ph: null,
                        created_at: "2022-08-26T09:50:21.000000Z",
                        updated_at: "2022-08-26T09:50:22.000000Z",
                        pivot: {
                            field_id: 12,
                            cadastral_parcel_id: 11,
                            area: 1.2,
                            created_at: "2022-08-26T09:50:22.000000Z",
                            updated_at: "2022-08-26T09:50:22.000000Z"
                        }
                    }
                ],
                crop: {
                    id: 5,
                    name: "Clare Hansen",
                    src: "/src/assets/crops/tomato.png",
                    created_at: "2022-08-02T19:35:24.000000Z",
                    updated_at: "2022-08-02T19:35:24.000000Z"
                },
                created_at: "2022-08-26T09:40:05.000000Z",
                updated_at: "2022-08-26T09:50:23.000000Z"
            }
        ],
        }
    },
    mutations,
    actions,
    getters
}