# SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
# SPDX-License-Identifier: CC0-1.0

import x'$LUNR_JUSTFILES/common.justfile'

set allow-duplicate-variables

export github_actions := env('GITHUB_ACTIONS', '0')
export default_coding_standard := env('LUNR_CODING_STANDARD', '/var/www/libs/lunr-coding-standard/Lunr/')

setup type='dev': (decomposer type)
