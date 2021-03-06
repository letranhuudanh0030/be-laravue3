export const strSlug = (string) => {
    return string
        .replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a')
        .replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e')
        .replace(/(ì|í|ị|ỉ|ĩ)/g, 'i')
        .replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o')
        .replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u')
        .replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y')
        .replace(/(đ)/g, 'd')
        .replace(/([^0-9a-zA-z-\s])/g, '')
        .replace(/(\s+)/g, '-')
        .replace(/^-+/g, '')
        .replace(/-+$/g, '')
        .replace(/--+/g, '-')
        .toLowerCase()
        .trim()
}

export default { strSlug }
