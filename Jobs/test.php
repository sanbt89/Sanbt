<?php
/**
 * Created by PhpStorm.
 * User: slovet
 * Date: 5/22/16
 * Time: 10:13 AM
 */

$jobs_department_listing = listing(
    $data = [
        'js_config' => [
            'provider' => 'jobs_department_listing.jobs_department_listing_data_source',
            'deps' => 'jobs_department_listing.jobs_department_listing_data_source'
        ],
        'spinner' => 'jobs_department_columns',
        'buttons' => [
            'add' => [
                'name' => 'add',
                'label' => __('Add New Department'),
                'class' => 'primary',
                'url' => '*/*/new'
            ]
        ]
    ]
);

// data source 
$jobs_department_listing_data_source = $jobs_department_listing->dataSource(
    $dataProvider = configurableObject(
        $class = 'DepartmentGridDataProvider', // Data provider class
        $name = 'jobs_department_listing_data_source', // provider defined above 
        $primaryFieldName = 'entity_id', // primary key
        $requestFieldName = 'id', // url name parameter 
        $data = [
            'config' => [
                'component' => 'Magento_Ui/js/grid/provider',
                'update_url' => url( $path = 'mui/index/render' ),
                'storageConfig' => [
                    'indexField' => 'entity_id'
                ]
            ]
        ]
    )
);

// Container Listing Top
$listing_top = $jobs_department_listing->container(
    $data = [
        'config' => [
            'template' => 'ui/grid/toolbar'
        ]
    ]
);

// button to manage view 
$bookmarks = $listing_top->bookmark(
    $data = [
        'config' => [
            'component' => 'Magento_Ui/js/grid/controls/bookmarks/bookmarks',
            'displayArea' => 'dataGridActions',
            'storageConfig' => [
                'saveUrl' => url( $path = 'mui/bookmark/save' ),
                'deleteUrl' => url( $path = 'mui/bookmark/delete' ),
                'namespace' => 'jobs_department_listing'
            ]
        ]
    ]
);

// button to manage columns 
$columns_controls = $listing_top->container(
    $data = [
        'config' => [
            'columnsData' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.jobs_department_columns'
            ],
            'component' => 'Magento_Ui/js/grid/controls/columns',
            'dsplayArea' => 'dataGridActions'
        ]
    ]
);

// filters 
$listing_filters = $listing_top->filters(
    $data = [
        'config' => [
            'storageConfig' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks',
                'namespace' => 'current.filters'
            ],
            'childDefaults' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.listing_filters',
                'imports' => [
                    'visible' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks:current.columns.${ $.index }.visible'
                ]
            ]
        ]
    ]
);

// Department ID filter range 
$department_id = $listing_filters->filterRange(
    $data = [
        'config' => [
            'dataScope' => '', // Column name in DB
            'label' => __('ID'), // Label on grid
            'childDefaults' => [
                'provider' => ''
            ]
        ]
    ]
);
// from filter input 
$from = $department_id->filterInput(
    $data = [
        'config' => [
            'dataScope' => 'from',
            'label' => __('from'),
            'placeholder' => __('From')
        ]
    ]
);
// to filter input 
$to = $department_id->filterInput(
    $data = [
        'config' => [
            'dataScope' => 'to',
            'label' => __('to'),
            'placeholder' => __('To')
        ]
    ]
);

// Department name filter input
$department_name = $listing_filters->filterInput(
    $data = [
        'config' => [
            'provider' => 'jobs_department_listing.jobs_department_listing_data_source',
            'chipsProvider' => 'jobs_department_listing.jobs_department_listing.listing_top.listing_filters_chips',
            'storageConfig' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks',
                'namespace' => 'current.search'
            ]
        ]
    ]
);

// Mass action
$listing_massaction = $listing_top->massaction(
    $data = [
        'config' => [
            'selectProvider' => '',
            'indexField' => 'entity_id'
        ]
    ]
);
// mass delete action 
$delete = $listing_massaction->action(
    $data = [
        'config' => [
            'type' => 'delete',
            'label' => __('Delete'),
            'url' => url( $path = 'jobs/department/massDelete' ),
            'confirm' => [
                'title' => __('Delete items'),
                'message' => __('Are you sure you wan\'t to delete selected items?')
            ]
        ]
    ]
);

// Paging 
$listing_paging = $listing_top->paging(
    $data = [
        'config' => [
            'storageConfig' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks',
                'namespace' => 'current.paging'
            ],
            'selectProvider' => 'jobs_department_listing.jobs_department_listing.jobs_department_columns.ids',
            'displayArea' => 'bottom'
        ]
    ]
);

// Columns 
$jobs_department_columns = $jobs_department_listing->columns(
    $data = [
        'config' => [
            'storageConfig' => [
                'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks',
                'namespace' => 'current'
            ],
            'childDefaults' => [
                'controlVisibility' => true,
                'storageConfig' => [
                    'provider' => 'jobs_department_listing.jobs_department_listing.listing_top.bookmarks',
                    'root' => 'columns.${ $.index }',
                    'namespace' => 'current.${ $.storageConfig.root}'
                ]
            ]
        ]
    ]
);

// Add columns with checkboxes
$ids = $jobs_department_columns->selectionsColumn(
    $data = [
        'config' => [
            'resizeEnable' => false,
            'resizeDefaultWidth' => 55,
            'indexField' => 'entity_id'
        ]
    ]
);

// ID column
$entity_id = $jobs_department_columns->column(
    $data = [
        'config' => [
            'filter' => 'textRange',
            'sorting' => 'asc',
            'label' => __('ID')
        ]
    ]
);
// Name column
$name = $jobs_department_columns->column(
    $data = [
        'config' => [
            'filter' => 'text',
            'editor' => [
                'editorType' => 'text',
                'validation' => [
                    'required-entry' => true
                ]
            ],
            'label' => __('ID')
        ]
    ]
);

// Action column
$actions = $jobs_department_columns->actionsColumn(
    new Sanbt\Jobs\Ui\Component\Listing\Column\DepartmentActions(
        $data = [
            'config' => [
                'resizeEnabled' => false,
                'resizeDefaultWidth' => 108,
                'indexField' => 'entity_id'
            ]
        ]
    )
);
    



