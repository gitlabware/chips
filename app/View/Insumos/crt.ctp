<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Tables</h1>
    </hgroup>

    <div class="with-padding">		

        <h4>Styled table with advanced sorting</h4>

        <p>This example uses the plugin <a href="http://datatables.net">DataTables</a>:</p>

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="check-all" id="check-all" value="1"></th>
                    <th scope="col">Text</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Date</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Status</th>
                    <th scope="col" width="15%" class="hide-on-tablet">Tags</th>
                    <th scope="col" width="60" class="align-center">Actions</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <td colspan="6">
                        6 entries found
                    </td>
                </tr>
            </tfoot>

            <tbody>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-1" value="1"></th>
                    <td>John Doe</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-2" value="2"></th>
                    <td>John Appleseed</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag orange-bg">Non-verified</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-3" value="3"></th>
                    <td>Sheldon Cooper</td>
                    <td>Jul 4, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-4" value="4"></th>
                    <td>Rage Guy</td>
                    <td>Jun 25, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag red-bg">Fake</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-5" value="5"></th>
                    <td>Thomas A. Anderson</td>
                    <td>Jun 16, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-6" value="6"></th>
                    <td>Jane Doe</td>
                    <td>May 19, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-1" value="1"></th>
                    <td>John Doe</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-2" value="2"></th>
                    <td>John Appleseed</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag orange-bg">Non-verified</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-3" value="3"></th>
                    <td>Sheldon Cooper</td>
                    <td>Jul 4, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-4" value="4"></th>
                    <td>Rage Guy</td>
                    <td>Jun 25, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag red-bg">Fake</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-5" value="5"></th>
                    <td>Thomas A. Anderson</td>
                    <td>Jun 16, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-6" value="6"></th>
                    <td>Jane Doe</td>
                    <td>May 19, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-1" value="1"></th>
                    <td>John Doe</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-2" value="2"></th>
                    <td>John Appleseed</td>
                    <td>Jul 5, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag orange-bg">Non-verified</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-3" value="3"></th>
                    <td>Sheldon Cooper</td>
                    <td>Jul 4, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-4" value="4"></th>
                    <td>Rage Guy</td>
                    <td>Jun 25, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag red-bg">Fake</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-5" value="5"></th>
                    <td>Thomas A. Anderson</td>
                    <td>Jun 16, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small> <small class="tag green-bg">Valid</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
                <tr>
                    <th scope="row" class="checkbox-cell"><input type="checkbox" name="checked[]" id="check-6" value="6"></th>
                    <td>Jane Doe</td>
                    <td>May 19, 2011</td>
                    <td>Enabled</td>
                    <td><small class="tag">User</small> <small class="tag">Client</small></td>
                    <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                </tr>
            </tbody>

        </table>

        <h4>Styled table with simple sorting</h4>		

    </div>

</section>