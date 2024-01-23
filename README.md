# ChunkUpload

ChunkUpload allows the chunked uploading and merging of files to be uploaded. You can customize it to fit your own design with an example InertiaJs component. It performs the upload process into the specified disk. If there is a route specified in the upload process, it uses that route. If you want to delete, it removes the relevant file. If you activate automatic deletion, it performs the deletion process based on the minute you have specified or the data on the config.

**NOTE: We recommend specifying a special disk for the deletion process. All files in the specified directory will be affected!**

## Installation

You can install ChunkUpload via Composer. Run the following command in your Laravel project directory:

```bash
composer require yunusemrebaloglu/chunk-upload
```

## Configuration

To publish the package's configuration file, run the following command:

```bash
php artisan vendor:publish --tag=chunk-upload-config
```

This will copy the configuration file to your `config` directory where you can customize it.

```bash
php artisan vendor:publish --tag=chunk-upload-inertia-components
```

This will copy the configuration file to the InertiaJs component 'components' directory where you can customize it.

## Usage

For the Chunk Upload process, first include the relevant component.

```javascript
import FileUpload from "@/Components/FileUpload.vue";
```

You can perform design and editing operations via the relevant component.

```html
<FileUpload v-model="form.file_name"></FileUpload>
```

This component can work with v-model.

After the file is uploaded, you can process the file on the disk you have provided via the config with this name.

```php
Storage::disk('custom_disk')->makeDirectory($model->id . '/files/');

File::move(Storage::disk('The disk name you specified via config')->path($request->file_name), Storage::disk('listing')->path($model->id . '/zip/' . $request->file_name));
```

### Delete Files

**NOTE: We recommend specifying a special disk for the deletion process. All files in the specified directory will be affected!**

The command below retrieves files from the disk you specified. It compares with the time specified in minutes on the config. If the time has passed, it deletes the files.

```bash
php artisan chunk-upload:delete_files
```

## License

ChunkUpload is open-sourced software licensed under the [MIT license](LICENSE.md).
