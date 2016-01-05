Grunt commands
==============

``less``
    Recompiles all LESS files into their corresponding CSS files, including sourcemaps, and then runs ``cssmin``.
    The list of files that will be compiled is defined in ``Gruntfile.js`` in the variable ``cssLessFiles``.

``uglify``
    Minifies Largo's ``.js`` JavaScript files to ``.min.js`` files.

``cssmin``
    Takes all ``.css`` files in ``css/`` and ``homepages/assets/css`` that are not ``.min.css`` files and makes minified versions with the file extension ``.min.css``.

``shell``
    Runs commands directly on the command line, instead of running Grunt modules.

    ``shell:apidocs``
        Recompiles the `Largo API Docs </api/>`_ from structured comments in Largo's PHP code using `/docs/generate_api_docs.py <https://github.com/INN/Largo/blob/master/docs/generate_api_docs.py>`_ into reStructuredText files.

    ``shell:sphinx``
        Converts all available reStructuredText files into HTML documentation, which is saved locally in ``docs/_build/html/``. If you want to preview these docs without pushing them to `largo.readthedocs.org <https://largo.readthedocs.org>`_, run ``python -m SimpleHTTPServer`` as described in `the documentation contribution instructions <setup-documentation.html#setting-up>`_.

    ``shell:msmerge``
        Runs `msgmerge <https://www.gnu.org/software/gettext/manual/html_node/msgmerge-Invocation.html>`_ to merge translation files.

``watch``
    Runs ``less`` if a ``.less`` file in ``less/`` or ``homepages/assets/less/`` is modified.
    Runs ``docs`` if a reStructuredText ``.rst`` file changes in ``docs/``.

``pot``
    Scans the Largo code for the WordPress localization functions and generates ``.po`` files for working with localization software.

``po2mo``
    Converts the ``.po`` files to ``.mo`` files. For more information about ``.po`` and ``.mo`` files, see the `Wikipedia articles on gettext <https://en.wikipedia.org/wiki/Gettext>`_.

``apidocs``
    Runs ``shell:apidocs``, rebuilding only the API docs.

``docs``
    Runs ``shell:sphinx``, rebuilding ALL docs.

``build``
    Runs ``less``, ``cssmin``, ``uglify``, ``apidocs``, ``docs``, ``pot``, and ``shell:msmerge`` to rebuild the assets, docs, and language files.

``version``
    Increments the Largo version number based on ``package.json``. Files affected are: ``docs/conf.py``, ``style.css``, ``readme.md``.

``build-release``
    Runs ``build`` and ``version``.

``publish``
    Runs the following tasks to publish the newest version of Largo on the ``master`` branch:

    ``confirm``
        Makes sure that you want to publish a release.

    ``gitcheckout``
        Checks out the ``master`` branch of Largo.

    ``gitmerge``
        Merges the ``develop`` branch into ``master``.

    ``gittag``
        Tags the latest commit with the version number from ``package.json``.

    ``gitpush``
        Pushes the ``master`` branch back to GitHub.


