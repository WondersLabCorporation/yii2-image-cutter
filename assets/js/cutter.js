$.fn.cutter = function (options) {
    'use strict';

    var $cropped = false;

    var $uploadField = $(this);

    var $cropperOptions = options['cropperOptions'];
    var $useWindowHeight = options['useWindowHeight'];

    var $cutter = $(this).parents('.image-cutter');

    var $modal = $cutter.find('.modal');
    var $imageContainer = $cutter.find('.image-container');
    var $preview = $cutter.find('.preview-image');
    var $cropperData = $cutter.find('.cropping-data');

    var $initialImageSrc = $preview.prop('src');

    $uploadField.change(function (e) {
        var file = e.target.files[0],
            imageType = /image.*/;

        if (!file.type.match(imageType)) {
            return;
        }

        var reader = new FileReader();

        reader.onload = fileOnload;
        reader.readAsDataURL(file);
    });

    $cutter.on('click', '.button_accept', function () {
        var data = $imageContainer.find('img.cropped-image').cropper('getData');

        $.each(data, function () {
            if (this != 0) {
                $cropped = true;
            }
        });

        if ($cropped) {
            var canvas = $imageContainer.find('img.cropped-image').cropper('getCroppedCanvas');
            var dataURL = canvas.toDataURL();

            $preview.prop('src', dataURL);
        }

        $modal.modal('hide');
    });

    $cutter.on('click', '.button_cancel', function () {
        $modal.modal('hide');
    });

    $modal.on('hidden.bs.modal', function () {
        if (!$cropped) {
            // On cancelling or failed cropping need to reset fileInput and preview value.
            $preview.prop('src', $initialImageSrc);
            // Due to browser restrictions fileInput value can be set to empty string only
            $uploadField.replaceWith($uploadField.val('').clone(true));
        }

        $cropped = false;

        $imageContainer.find('img.cropped-image').removeAttr("src").removeAttr("style");
    });

    function fileOnload(e) {
        var imageField = $imageContainer.find('img.cropped-image').prop('outerHTML');

        $imageContainer.html('').append(imageField);

        $imageContainer.find('img.cropped-image').prop('src', e.target.result.toString()).hide();

        $modal.on('shown.bs.modal', function (a) {
            var size = getImageContainerSize();

            $imageContainer.css({
                width: size.width + 'px',
                height: size.height + 'px'
            });

            var options = $.extend({}, $cropperOptions, {
                'crop': function (data) {
                    $cropperData.val(JSON.stringify({
                        'dataRotate': Math.round(data.rotate),
                        'dataX': Math.round(data.x),
                        'dataY': Math.round(data.y),
                        'dataWidth': Math.round(data.width),
                        'dataHeight': Math.round(data.height),
                    }));
                }
            });

            $imageContainer.find('img.cropped-image').cropper('destroy');
            $imageContainer.find('img.cropped-image').cropper(options);
        });

        $modal.modal('show');
    }

    function getImageContainerSize() {
        var height;
        var width = $imageContainer.width();
        var minHeight = 100;

        var imageWidth = $imageContainer.find('img.cropped-image').width();
        var imageHeight = $imageContainer.find('img.cropped-image').height();

        if (imageWidth > imageHeight) {
            var aspectRatio = imageWidth / width;
            height = imageHeight / aspectRatio;
        } else if (imageWidth < imageHeight) {
            if (imageWidth < width) {
                width = imageWidth;
                height = imageHeight;
            } else {
                var aspectRatio = imageWidth / width;
                height = imageHeight / aspectRatio;
            }
        } else if (imageWidth == imageHeight) {
            if (imageWidth < width) {
                height = imageHeight;
            } else {
                height = width;
            }

            if (height < minHeight) {
                height = minHeight;
            }
        }

        if ($useWindowHeight) {
            height = $(window).height() - 300;
        }

        return {
            'width': width,
            'height': height
        }
    }

    $cutter.on('click', '[data-method]', function () {
        var method = $(this).data('method');
        var option = $(this).data('option');

        var $modal = $(this).closest('.modal');
        var $imageContainer = $modal.find('.image-container');
        var $image = $imageContainer.find('img.cropped-image');

        if (method) {
            $image.cropper(method, option);

        }

        return false;
    });
};