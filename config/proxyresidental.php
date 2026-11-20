<?php

$dedicated_mobile = 'dedicated-mobile';
$rotating_mobile = 'rotating-mobile';
$rotating_residential = 'rotating-residential';
$static_datacenter_ipv4 = 'static-datacenter-ipv4';
$static_datacenter_ipv6 = 'static-datacenter-ipv6';
$static_residential_ipv4 = 'static-residential-ipv4';
$static_residential_ipv6 = 'static-residential-ipv6';

return [
    'setting' => [
        'availableTypes' => [
            "HTTP",
            "SOCKS5"
        ],
        'isps' => [
            'IT' => [
                'd4298486-77d0-11ee-8111-0afa29ca1928' => [
                    'id' => 'd4298486-77d0-11ee-8111-0afa29ca1928',
                    'label' => 'ACE TELECOMS',
                ],
                '9de574fb-c344-11ed-89cd-069b3a488940' => [
                    'id' => '9de574fb-c344-11ed-89cd-069b3a488940',
                    'label' => 'SC Aside MCD SRL',
                ],
            ],
            'HK' => [
                '78063ab0-509f-11ee-87f9-0afa29ca1928' => [
                    'id' => '78063ab0-509f-11ee-87f9-0afa29ca1928',
                    'label' => 'Bunny Communications',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],
            'US' => [
                'c8376195-a0b5-11ee-8311-0afa29ca1928' => [
                    'id' => 'c8376195-a0b5-11ee-8311-0afa29ca1928',
                    'label' => 'CAMPLINK',
                ],
                'ac42d7f7-4f86-11ed-a3ee-069b3a488940' => [
                    'id' => 'ac42d7f7-4f86-11ed-a3ee-069b3a488940',
                    'label' => 'CenturyLink',
                ],
                '00fc70e1-a271-11ef-8cc6-0ac79cee8129' => [
                    'id' => '00fc70e1-a271-11ef-8cc6-0ac79cee8129',
                    'label' => 'Cogent',
                ],
                'e90710b4-ee2b-11ec-85c2-06902e647790' => [
                    'id' => 'e90710b4-ee2b-11ec-85c2-06902e647790',
                    'label' => 'Comcast',
                ],
                'e3d827a9-ee2b-11ec-85c2-06902e647790' => [
                    'id' => 'e3d827a9-ee2b-11ec-85c2-06902e647790',
                    'label' => 'Crocker Communications',
                ],
                '01990465-dedb-701a-b99c-53a62624084c' => [
                    'id' => '01990465-dedb-701a-b99c-53a62624084c',
                    'label' => 'Flux Telecom',
                ],
                'b79a51ca-e5f3-11ee-9188-0641008c0bf7' => [
                    'id' => 'b79a51ca-e5f3-11ee-9188-0641008c0bf7',
                    'label' => 'Frontier',
                ],
                '5905583c-d654-11ee-9188-0641008c0bf7' => [
                    'id' => '5905583c-d654-11ee-9188-0641008c0bf7',
                    'label' => 'GTT',
                ],
                'c35b2dd6-c33f-11ed-89cd-069b3a488940' => [
                    'id' => 'c35b2dd6-c33f-11ed-89cd-069b3a488940',
                    'label' => 'Intercom Online',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                'a38e2deb-c7c3-11ed-89cd-069b3a488940' => [
                    'id' => 'a38e2deb-c7c3-11ed-89cd-069b3a488940',
                    'label' => 'Lumen',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                'bf22ae6b-765f-11ef-b719-0ac79cee8129' => [
                    'id' => 'bf22ae6b-765f-11ef-b719-0ac79cee8129',
                    'label' => 'NTT',
                ],
                'ec64aa6f-ee2b-11ec-85c2-06902e647790' => [
                    'id' => 'ec64aa6f-ee2b-11ec-85c2-06902e647790',
                    'label' => 'RCN',
                ],
                '019970f8-255f-768f-8ad7-6a58eebbf000' => [
                    'id' => '019970f8-255f-768f-8ad7-6a58eebbf000',
                    'label' => 'Thunderbox',
                ],
                'bf41595b-e82f-11ee-a5c4-0641008c0bf7' => [
                    'id' => 'bf41595b-e82f-11ee-a5c4-0641008c0bf7',
                    'label' => 'Verizon Business',
                ],
                'e50ed9de-f468-11ef-8647-0204b4dab599' => [
                    'id' => 'e50ed9de-f468-11ef-8647-0204b4dab599',
                    'label' => 'WGIX',
                ],
                '23a8454c-9428-11ee-8311-0afa29ca1928' => [
                    'id' => '23a8454c-9428-11ee-8311-0afa29ca1928',
                    'label' => 'Windstream',
                ],
                'ef3fb61f-a270-11ef-8cc6-0ac79cee8129' => [
                    'id' => 'ef3fb61f-a270-11ef-8cc6-0ac79cee8129',
                    'label' => 'Zayo',
                ],
            ],
            'HU' => [
                '90c45695-cd39-11ed-89cd-069b3a488940' => [
                    'id' => '90c45695-cd39-11ed-89cd-069b3a488940',
                    'label' => 'Giganet Internet',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],
            'FR' => [
                '390b49e9-71b8-11ef-b719-0ac79cee8129' => [
                    'id' => '390b49e9-71b8-11ef-b719-0ac79cee8129',
                    'label' => 'Habeum SAS',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '30ac8588-bcf5-11ed-89cd-069b3a488940' => [
                    'id' => '30ac8588-bcf5-11ed-89cd-069b3a488940',
                    'label' => 'Sc Technological Sr',
                ],
            ],
            'HN' => [
                'c69f6fe8-19db-11f0-8647-0204b4dab599' => [
                    'id' => 'c69f6fe8-19db-11f0-8647-0204b4dab599',
                    'label' => 'Ingenieria Telecomunicaciones S.A de CV',
                ],
            ],
            'DE' => [
                'd7186d88-9d7a-11ed-89cd-069b3a488940' => [
                    'id' => 'd7186d88-9d7a-11ed-89cd-069b3a488940',
                    'label' => 'Liberty Global',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                'b869598b-a3de-11ed-89cd-069b3a488940' => [
                    'id' => 'b869598b-a3de-11ed-89cd-069b3a488940',
                    'label' => 'ZyNOX',
                ],
            ],
            'NL' => [
                'd7186d88-9d7a-11ed-89cd-069b3a488940' => [
                    'id' => 'd7186d88-9d7a-11ed-89cd-069b3a488940',
                    'label' => 'Liberty Global',
                ],
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],
            'AT' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                'fba5bb41-09c0-11ed-b596-069b3a488940' => [
                    'id' => 'fba5bb41-09c0-11ed-b596-069b3a488940',
                    'label' => 'Video-Broadcast GmbH',
                ],
            ],
            "AU" => [
                "2b07249d-7d7e-11ee-875b-0afa29ca1928" => [
                    "id" => "2b07249d-7d7e-11ee-875b-0afa29ca1928",
                    "label" => "Lietpark Communications"
                ],
                "01991455-44c6-7225-baa3-da525857146b" => [
                    "id" => "01991455-44c6-7225-baa3-da525857146b",
                    "label" => "Lumina Broadband"
                ],
            ],
            'BG' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '780773c4-b119-11ed-89cd-069b3a488940' => [
                    'id' => '780773c4-b119-11ed-89cd-069b3a488940',
                    'label' => 'Sofcompany',
                ],
            ],

            'BR' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '4ba7b548-a7a7-11ed-89cd-069b3a488940' => [
                    'id' => '4ba7b548-a7a7-11ed-89cd-069b3a488940',
                    'label' => 'ML Telecom',
                ],
            ],

            'CA' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                'a38e2deb-c7c3-11ed-89cd-069b3a488940' => [
                    'id' => 'a38e2deb-c7c3-11ed-89cd-069b3a488940',
                    'label' => 'Lumen',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'CH' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'CL' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'CO' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'CZ' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                'd1267760-c419-11ed-89cd-069b3a488940' => [
                    'id' => 'd1267760-c419-11ed-89cd-069b3a488940',
                    'label' => 'RelINFO',
                ],
            ],

            'DK' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '9de574fb-c344-11ed-89cd-069b3a488940' => [
                    'id' => '9de574fb-c344-11ed-89cd-069b3a488940',
                    'label' => 'SC Aside MCD SRL',
                ],
            ],

            'ES' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'FI' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'GB' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                'bf22ae6b-765f-11ef-b719-0ac79cee8129' => [
                    'id' => 'bf22ae6b-765f-11ef-b719-0ac79cee8129',
                    'label' => 'NTT',
                ],
                'abfcf555-1e11-11ed-a3ee-069b3a488940' => [
                    'id' => 'abfcf555-1e11-11ed-a3ee-069b3a488940',
                    'label' => 'Pro Marketing Central LLC',
                ],
                '30ac8588-bcf5-11ed-89cd-069b3a488940' => [
                    'id' => '30ac8588-bcf5-11ed-89cd-069b3a488940',
                    'label' => 'Sc Technological Sr',
                ],
            ],

            'GR' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'HR' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'IE' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'IL' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'JP' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'LT' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],

            'MX' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'MY' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'NG' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'NO' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'PE' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'PL' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                'b42badac-7608-11ed-9ad1-069b3a488940' => [
                    'id' => 'b42badac-7608-11ed-9ad1-069b3a488940',
                    'label' => 'Zodoms International',
                ],
            ],

            'PT' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],

            'SG' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '2efd195b-6bf4-11ed-9ad1-069b3a488940' => [
                    'id' => '2efd195b-6bf4-11ed-9ad1-069b3a488940',
                    'label' => 'WebSatMedia',
                ],
            ],

            'SK' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],

            'TR' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],

            'UA' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'ZA' => [
                '2b07249d-7d7e-11ee-875b-0afa29ca1928' => [
                    'id' => '2b07249d-7d7e-11ee-875b-0afa29ca1928',
                    'label' => 'Lietpark Communications',
                ],
            ],

            'AR' => [
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'BD' => [
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'KR' => [
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'TW' => [
                '01991455-44c6-7225-baa3-da525857146b' => [
                    'id' => '01991455-44c6-7225-baa3-da525857146b',
                    'label' => 'Lumina Broadband',
                ],
            ],

            'RO' => [
                '71225eb1-7696-11ef-b719-0ac79cee8129' => [
                    'id' => '71225eb1-7696-11ef-b719-0ac79cee8129',
                    'label' => 'Teen telcom',
                ],
            ],

            'RS' => [
                'dddaac83-193a-11f0-8647-0204b4dab599' => [
                    'id' => 'dddaac83-193a-11f0-8647-0204b4dab599',
                    'label' => 'Telekom Srbija a.d.',
                ],
            ],

            'AE' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'ID' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'IN' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'PH' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'TH' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'VN' => [
                '23b0a5df-e9e9-11ef-8647-0204b4dab599' => [
                    'id' => '23b0a5df-e9e9-11ef-8647-0204b4dab599',
                    'label' => 'Zenlayer',
                ],
            ],

            'BE' => [
                'b42badac-7608-11ed-9ad1-069b3a488940' => [
                    'id' => 'b42badac-7608-11ed-9ad1-069b3a488940',
                    'label' => 'Zodoms International',
                ],
            ],
        ],

    ],
    $dedicated_mobile => [
        'name' => 'Static Mobile',
        'type' => 'static',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'proxy',
                    'months' => 1
                ]
            ],
            "plans" => [
                "dedicated" => [
                    "id" => "dedicated",
                    "label" => "Chuyên dụng",
                    "price" => 12.9,
                    "popular" => false,
                    "list_provided" => [
                        ["label" => "Dành riêng cho một người dùng", "status" => "checked"],
                        ["label" => "Băng thông không giới hạn", "status" => "checked"],
                        ["label" => "Tốc độ 2-5 Mbit/giây", "status" => "checked"]
                    ]
                ],
            ]
        ]
    ],
    $rotating_mobile => [
        'name' => 'Rotating Mobile',
        'type' => 'rotating',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'GB',
                    'months' => 1
                ]
            ],
            "plans" => [],
            "price" => 5.99,
        ]
    ],
    $rotating_residential => [
        'name' => 'Rotating Residential',
        'type' => 'rotating',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'GB',
                    'months' => 1
                ]
            ],
            "plans" => [],
            "price" => 4.99
        ]
    ],
    $static_datacenter_ipv4 => [
        'name' => 'Static Datacenter (IPv4)',
        'type' => 'static',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'tháng',
                    'months' => 1
                ]
            ],
            "plans" => [
                "basic" => [
                    "id" => "basic",
                    "label" => "Cơ bản",
                    "price" => 1.39,
                    "popular" => false,
                    "list_provided" => [
                        ["label" => "Tối đa 3 người dùng được sử dụng", "status" => "checked"],
                        ["label" => "Giới hạn băng thông 1GB", "status" => "checked"],
                        ["label" => "Không nâng cấp tốc độ", "status" => "uncheck"],
                        ["label" => "Không nâng cấp đồng thời", "status" => "uncheck"]
                    ]
                ],
                "standard" => [
                    "id" => "standard",
                    "label" => "Chuyên dụng",
                    "price" => 1.69,
                    "popular" => true,
                    "list_provided" => [
                        ["label" => "Dành riêng cho một người dùng", 'status' => "checked"],
                        ["label" => "Băng thông không giới hạn", "status" => "checked"],
                        ["label" => "Nâng cấp tốc độ", "status" => "checked"],
                        ["label" => "Nâng cấp đồng thời", "status" => "checked"]
                    ]
                ],
                "premium" => [
                    "id" => "premium",
                    "label" => "Cao cấp",
                    "price" => 4.49,
                    "popular" => false,
                    "list_provided" => [
                        ["label" => "IP chưa sử dụng", 'status' => "checked"],
                        ["label" => "Băng thông không giới hạn", "status" => "checked"],
                        ["label" => "Nâng cấp tốc độ", "status" => "checked"],
                        ["label" => "Nâng cấp đồng thời", "status" => "checked"]
                    ]
                ],
            ]
        ]
    ],
    $static_datacenter_ipv6 => [
        'name' => 'Static Datacenter (IPv6)',
        'type' => 'static',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'tháng',
                    'months' => 1
                ]
            ],
            "countries" => ["US", "SG", "SE", "RO", "PL", "NO", "NL", "JP", "IT", "HU", "HK", "GB", "FR", "FI", "ES", "DK", "DE", "CN", "CH", "CA", "BG", "BE", "AU", "AT", "AE"],
            "months" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            "packages" => ["10", "50", "150", "500"],
            "plans" => [],
            "price" => 0.15 * 30,
        ]
    ],
    $static_residential_ipv4 => [
        'name' => 'Static Residential (IPv4) (ISP)',
        'type' => 'static',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'tháng',
                    'months' => 1
                ]
            ],
            "plans" => [
                "basic" => [
                    "id" => "basic",
                    "label" => "Cơ bản",
                    "price" => 2.29,
                    "popular" => false,
                    "list_provided" => [
                        ["label" => "Tối đa 3 người dùng được sử dụng", "status" => "checked"],
                        ["label" => "Giới hạn băng thông 1GB", "status" => "checked"],
                        ["label" => "Không nâng cấp tốc độ", "status" => "uncheck"],
                        ["label" => "Không nâng cấp đồng thời", "status" => "uncheck"]
                    ]
                ],
                "standard" => [
                    "id" => "standard",
                    "label" => "Chuyên dụng",
                    "price" => 2.49,
                    "popular" => true,
                    "list_provided" => [
                        ["label" => "Dành riêng cho một người dùng", 'status' => "checked"],
                        ["label" => "Băng thông không giới hạn", "status" => "checked"],
                        ["label" => "Nâng cấp tốc độ", "status" => "checked"],
                        ["label" => "Nâng cấp đồng thời", "status" => "checked"]
                    ]
                ],
                "premium" => [
                    "id" => "premium",
                    "label" => "Cao cấp",
                    "price" => 7.49,
                    "popular" => false,
                    "list_provided" => [
                        ["label" => "IP chưa sử dụng", 'status' => "checked"],
                        ["label" => "Băng thông không giới hạn", "status" => "checked"],
                        ["label" => "Nâng cấp tốc độ", "status" => "checked"],
                        ["label" => "Nâng cấp đồng thời", "status" => "checked"]
                    ]
                ],
            ]
        ]
    ],
    $static_residential_ipv6 => [
        'name' => 'Static Residential (IPv6)',
        'type' => 'static',
        'protocol' => 'HTTP',
        'metadata' => [
            'fee' => 5,
            'specialOffer' => [
                'discount' => 0,
                'properties' => [
                    'unit' => 'tháng',
                    'months' => 1
                ]
            ],
            "plans" => [],
            "price" => 0.15 * 30,
        ]
    ],
];
