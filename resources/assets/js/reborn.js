function fileDelete(name, url)
{
    if (confirm('Etes vous sûr de vouloir supprimer "' + name + '" ?'))
    {
        window.location.href = url;
    }

    return false;
}